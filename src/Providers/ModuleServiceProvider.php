<?php

declare(strict_types=1);

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

use Illuminate\Support\Facades\Route;
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
use Konekt\AppShell\Models\Address;
use Konekt\AppShell\Models\GravatarDefault;
use Konekt\AppShell\Models\User;
use Konekt\Concord\BaseBoxServiceProvider;
use Konekt\User\Contracts\User as UserContract;
use Menu;

class ModuleServiceProvider extends BaseBoxServiceProvider
{
    use HasBreadcrumbs;
    use BootsMenuServiceProvider;

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
        $this->app->register(UiServiceProvider::class);

        // Register Helpers:
        $this->concord->registerHelper('color', ColorHelper::class);
        $this->concord->registerHelper('date', DateHelper::class);
        $this->concord->registerHelper('quickLinks', QuickLinkHelper::class);

        $this->registerCommands();
        $this->app->singleton(ResourcePermissionMapper::class, ResourcePermissionMapper::class);
    }

    public function boot()
    {
        parent::boot();

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

        $this->bootAppShellMenus();
    }

    /**
     * Register AppShell commands
     */
    protected function registerCommands()
    {
        if ($this->app->runningInConsole() && !$this->config('disable.commands')) {
            $this->commands([
                SuperCommand::class
            ]);
        }
    }
}
