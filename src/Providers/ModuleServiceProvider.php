<?php
/**
 * Contains the ModuleServiceProvider class.
 *
 * @copyright   Copyright (c) 2016 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2016-11-30
 *
 */


namespace Konekt\AppShell\Providers;


use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Konekt\Address\Contracts\Address as AddressContract;
use Konekt\AppShell\Breadcrumbs\HasBreadcrumbs;
use Konekt\AppShell\Console\Commands\ScaffoldCommand;
use Konekt\AppShell\Console\Commands\SuperCommand;
use Konekt\AppShell\Http\Middleware\AclMiddleware;
use Konekt\AppShell\Http\Requests\CreateAddress;
use Konekt\AppShell\Http\Requests\CreateAddressForm;
use Konekt\AppShell\Http\Requests\CreateCustomer;
use Konekt\AppShell\Http\Requests\CreateRole;
use Konekt\AppShell\Http\Requests\CreateUser;
use Konekt\AppShell\Http\Requests\UpdateCustomer;
use Konekt\AppShell\Http\Requests\UpdateRole;
use Konekt\AppShell\Http\Requests\UpdateUser;
use Konekt\AppShell\Icons\EnumIconMapper;
use Konekt\AppShell\Icons\ZmdiAppShellIcons;
use Konekt\AppShell\Models\Address;
use Konekt\AppShell\Models\User;
use Konekt\Concord\BaseBoxServiceProvider;
use Konekt\User\Contracts\User as UserContract;
use Menu;

class ModuleServiceProvider extends BaseBoxServiceProvider
{
    use HasBreadcrumbs;

    protected $requests = [
        CreateUser::class,
        UpdateUser::class,
        CreateRole::class,
        UpdateRole::class,
        CreateCustomer::class,
        UpdateCustomer::class,
        CreateAddressForm::class,
        CreateAddress::class
    ];

    public function register()
    {
        parent::register();

        $this->app->register(AuthServiceProvider::class);
        $this->registerThirdPartyProviders();
        $this->registerCommands();
        $this->app->singleton('appshell.icon', EnumIconMapper::class);
    }

    public function boot()
    {
        parent::boot();

        (new ZmdiAppShellIcons($this->app->make('appshell.icon')))->registerIcons();

        $this->initUiData();
        $this->loadBreadcrumbs();

        // Use the User model that's extended with Acl
        $this->concord->registerModel(UserContract::class, User::class);
        // Use the Address model that's extended with Customers
        $this->concord->registerModel(AddressContract::class, Address::class);

        Route::aliasMiddleware('acl', AclMiddleware::class);

        $this->initializeMenus();
    }

    /**
     * Registers 3rd party providers, AppShell is built on top of
     *
     * They are:
     *  - Konekt Menu,
     *  - Laravel Collective Forms
     *  - Laracasts Flash
     *  - DaveJamesMiller Breadcrumbs
     */
    protected function registerThirdPartyProviders()
    {
        if (
            'testing' == $this->app->environment()
            ||
            version_compare(Application::VERSION, '5.5.0', '<')
        ) {
            $this->registerMenuComponent();
            $this->registerFormComponent();
            $this->registerFlashComponent();
            $this->registerBreadcrumbsComponent();
            $this->registerSluggableComponent();
        }

        $this->mergeBreadCrumbsConfig();
    }


    /**
     * Register appshell's commands
     */
    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ScaffoldCommand::class,
                SuperCommand::class
            ]);
        }
    }

    /**
     * Initializes menus set in the configuration
     */
    protected function initializeMenus()
    {
        foreach ($this->config('menu') as $name => $config) {
            Menu::create($name, $config);
        }

        // Add default menu items to sidbar
        if ($appshellMenu = Menu::get('appshell')) {
            // CRM Group
            $crm = $appshellMenu->addItem('crm', __('CRM'));

            $crm->addSubItem('customers', __('Customers'), ['route' => 'appshell.customer.index'])->data('icon', 'accounts-list');

            // Settings Group
            $settings = $appshellMenu->addItem('settings', __('Settings'));

            $settings->addSubItem('users', __('Users'), ['route' => 'appshell.user.index'])->data('icon', 'accounts');
            $settings->addSubItem('roles', __('Permissions'), ['route' => 'appshell.role.index'])->data('icon', 'shield-security');
        }
    }


    protected function initUiData()
    {
        View::share('appshell', (object) $this->config('ui'));
    }

    /**
     * Register Laravel Collective Form Component
     */
    private function registerFormComponent()
    {
        $this->app->register(\Collective\Html\HtmlServiceProvider::class);
        $this->concord->registerAlias('Form', \Collective\Html\FormFacade::class);
        $this->concord->registerAlias('Html', \Collective\Html\HtmlFacade::class);
    }

    /**
     * Registers Konekt Menu Component
     */
    private function registerMenuComponent()
    {
        $this->app->register(\Konekt\Menu\MenuServiceProvider::class);
        $this->concord->registerAlias('Menu', \Konekt\Menu\Facades\Menu::class);
    }

    /**
     * Register the Laracasts Flash Component
     */
    private function registerFlashComponent()
    {
        $this->app->register(\Laracasts\Flash\FlashServiceProvider::class);
    }

    /**
     * Register the breadcrumbs component, also merge the config from within the box config
     */
    private function registerBreadcrumbsComponent()
    {
        // Register The Breadcrumbs Component
        if (class_exists('\\DaveJamesMiller\\Breadcrumbs\\ServiceProvider')) { // Breadcrumbs v3.x - Laravel 5.4
            $this->app->register(\DaveJamesMiller\Breadcrumbs\ServiceProvider::class);
            $this->concord->registerAlias('Breadcrumbs', \DaveJamesMiller\Breadcrumbs\Facade::class);
        } else { // Breadcrumbs v4.x, v5.x - Laravel 5.5+
            $this->app->register(\DaveJamesMiller\Breadcrumbs\BreadcrumbsServiceProvider::class);
            $this->concord->registerAlias('Breadcrumbs', \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::class);
        }
    }

    /**
     * Register the sluggable component
     */
    private function registerSluggableComponent()
    {
        $this->app->register(\Cviebrock\EloquentSluggable\ServiceProvider::class);
    }

    /**
     * Merge component config from the box config.
     * Note that this can still be overwritten
     * by the app in config/breadcrumbs.php
     */
    private function mergeBreadCrumbsConfig()
    {
        $this->app['config']->set('breadcrumbs',
            array_merge(
                $this->config('components.breadcrumbs') ?: [],  // key within box config
                $this->app['config']['breadcrumbs'] ?: [] // current
            )
        );
    }


}
