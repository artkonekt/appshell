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
use Konekt\AppShell\Acl\ResourcePermissionMapper;
use Konekt\AppShell\Breadcrumbs\HasBreadcrumbs;
use Konekt\AppShell\Console\Commands\SuperCommand;
use Konekt\AppShell\Helpers\ColorHelper;
use Konekt\AppShell\Helpers\DateHelper;
use Konekt\AppShell\Helpers\QuickLinkHelper;
use Konekt\AppShell\Http\Middleware\AclMiddleware;
use Konekt\AppShell\Http\Requests\CreateAddress;
use Konekt\AppShell\Http\Requests\CreateAddressForm;
use Konekt\AppShell\Http\Requests\CreateCustomer;
use Konekt\AppShell\Http\Requests\CreateRole;
use Konekt\AppShell\Http\Requests\CreateUser;
use Konekt\AppShell\Http\Requests\EditAddressForm;
use Konekt\AppShell\Http\Requests\SaveAccount;
use Konekt\AppShell\Http\Requests\UpdateAddress;
use Konekt\AppShell\Http\Requests\UpdateCustomer;
use Konekt\AppShell\Http\Requests\UpdateRole;
use Konekt\AppShell\Http\Requests\UpdateUser;
use Konekt\AppShell\Icons\EnumIconMapper;
use Konekt\AppShell\Icons\ZmdiAppShellIcons;
use Konekt\AppShell\Models\Address;
use Konekt\AppShell\Models\GravatarDefault;
use Konekt\AppShell\Models\User;
use Konekt\AppShell\Theme\AppShell2Theme;
use Konekt\AppShell\Theme\DefaultAppShellTheme;
use Konekt\AppShell\Themes;
use Konekt\Concord\BaseBoxServiceProvider;
use Konekt\Gears\Facades\Settings;
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
        CreateAddress::class,
        EditAddressForm::class,
        UpdateAddress::class,
        SaveAccount::class
    ];

    protected $enums = [
        GravatarDefault::class
    ];

    public function register()
    {
        parent::register();

        $this->app->register(AuthServiceProvider::class);
        $this->app->register(ViewServiceProvider::class);
        $this->app->register(SettingsProvider::class);
        $this->app->register(PreferencesProvider::class);
        $this->concord->registerHelper('color', ColorHelper::class);
        $this->concord->registerHelper('date', DateHelper::class);
        $this->concord->registerHelper('quickLinks', QuickLinkHelper::class);
        Themes::add(DefaultAppShellTheme::ID, DefaultAppShellTheme::class);
        Themes::add(AppShell2Theme::ID, AppShell2Theme::class);
        $this->registerThirdPartyProviders();
        $this->registerCommands();
        $this->app->singleton(ResourcePermissionMapper::class, ResourcePermissionMapper::class);
        $this->app->singleton('appshell.icon', EnumIconMapper::class);
        $this->app->singleton('appshell.theme', function () {
            $theme = Themes::make(Settings::get('appshell.ui.theme'));
            $this->app['config']->set('breadcrumbs.view', $theme->viewNamespace() . '::widgets.breadcrumbs');

            return $theme;
        });
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

        $this->publishes([
            $this->getBasePath() . '/resources/views/auth/' =>
                resource_path('views/auth/'),
        ], 'auth-views');

        $this->initializeMenus();
    }

    /**
     * Registers 3rd party providers, AppShell is built on top of
     *
     * They are:
     *  - Konekt Menu,
     *  - Laravel Collective Forms
     *  - Laracasts Flash
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
            $this->registerSluggableComponent();
        }
    }

    /**
     * Register appshell's commands
     */
    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
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

        // Add default menu items to sidebar
        if ($appshellMenu = Menu::get('appshell')) {
            // CRM Group
            $crm = $appshellMenu->addItem('crm_group', __('CRM'));

            $crm
                ->addSubItem('customers', __('Customers'), ['route' => 'appshell.customer.index'])
                ->data('icon', 'accounts-list')
                ->activateOnUrls($this->routeWildcard('appshell.customer.index'))
                ->allowIfUserCan('list customers');

            // Settings Group
            $settings = $appshellMenu->addItem('settings_group', __('Settings'));

            $settings
                ->addSubItem('users', __('Users'), ['route' => 'appshell.user.index'])
                ->data('icon', 'accounts')
                ->activateOnUrls($this->routeWildcard('appshell.user.index'))
                ->allowIfUserCan('list users');
            $settings
                ->addSubItem('roles', __('Permissions'), ['route' => 'appshell.role.index'])
                ->data('icon', 'shield-security')
                ->activateOnUrls($this->routeWildcard('appshell.role.index'))
                ->allowIfUserCan('list roles');
            $settings
                ->addSubItem('settings', __('Settings'), ['route' => 'appshell.settings.index'])
                ->data('icon', 'settings')
                ->allowIfUserCan('list settings');
        }
    }

    protected function initUiData()
    {
        $uiConfig = $this->config('ui');

        if (!isset($uiConfig['routes'])) {
            $uiConfig['routes']['login']  = 'login';
            $uiConfig['routes']['logout'] = 'logout';
        }

        if (!isset($uiConfig['quick_links'])) {
            $uiConfig['quick_links']['enabled'] = true;
        }

        View::share('appshell', (object)$uiConfig);
    }

    private function routeWildcard(string $route): string
    {
        if (0 === strlen($path = parse_url(route($route), PHP_URL_PATH))) {
            return '';
        }

        if ('/' === $path[0]) {
            $path = substr($path, 1);
        }

        return "$path*";
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
     * Register the sluggable component
     */
    private function registerSluggableComponent()
    {
        $this->app->register(\Cviebrock\EloquentSluggable\ServiceProvider::class);
    }
}
