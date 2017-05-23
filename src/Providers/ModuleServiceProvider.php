<?php
/**
 * Contains the BoxServiceProvider class.
 *
 * @copyright   Copyright (c) 2016 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2016-11-30
 *
 */


namespace Konekt\AppShell\Providers;


use Illuminate\Support\Facades\Route;
use Konekt\AppShell\Console\Commands\ScaffoldCommand;
use Konekt\AppShell\Contracts\MenuBuilderInterface;
use Konekt\Concord\BaseBoxServiceProvider;
use Konekt\User\Models\UserProxy;

class ModuleServiceProvider extends BaseBoxServiceProvider
{
    public function register()
    {
        parent::register();

        $this->app->register(AuthServiceProvider::class);
        /** @todo Whether or not to register event/listener bindings
         *        provided by the box must be defined in box config
         *        and handled by Concord
         */
        $this->app->register(EventServiceProvider::class);
        $this->registerThirdPartyProviders();

        $this->registerCommands();

        $this->app->bind(MenuBuilderInterface::class, $this->config('menu.builder.class'));

        $this->app->when($this->config('menu.builder.class'))
                  ->needs('$menu')
                  ->give($this->app->make('menu'));
    }

    public function boot()
    {
        parent::boot();

        Route::model('user', UserProxy::modelClass());

        $menuBuilder = $this->app->make(MenuBuilderInterface::class);
        $menuBuilder->build($this->config('menu.name'));
    }

    /**
     * Registers 3rd party providers, AppShell is built on top of
     *
     * They are:
     *  - Lavary Menu,
     *  - Laravel Collective Forms
     *  - Laracasts Flash
     *  - Yajra Breadcrumbs
     */
    protected function registerThirdPartyProviders()
    {
        $this->registerMenuComponent();
        $this->registerFormComponent();
        $this->registerFlashComponent();
        $this->registerBreadcrumbsComponent();
    }


    /**
     * Register appshell's commands
     */
    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ScaffoldCommand::class
            ]);
        }
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
     * Registers Lavary Menu Component
     */
    private function registerMenuComponent()
    {
        $this->app->register(\Lavary\Menu\ServiceProvider::class);
        $this->concord->registerAlias('Menu', \Lavary\Menu\Facade::class);
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
        $this->app->register(\Yajra\Breadcrumbs\ServiceProvider::class);
        $this->concord->registerAlias('Breadcrumbs', \Yajra\Breadcrumbs\Facade::class);

        // Merge component config from the box config
        // Note that this can still be overwritten
        // by the app in config/breadcrumbs.php
        $this->app['config']->set('breadcrumbs',
            array_merge(
                $this->config('components.breadcrumbs'),  // key within box config
                $this->app['config']['breadcrumbs'] ?: [] // current
            )
        );
    }


}