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
        $this->app->register(\Lavary\Menu\ServiceProvider::class);
        $this->concord->registerAlias('Menu', \Lavary\Menu\Facade::class);

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


}