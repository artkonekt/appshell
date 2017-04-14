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


use Konekt\AppShell\Console\Commands\ScaffoldCommand;
use Konekt\AppShell\Contracts\MenuBuilderInterface;
use Konekt\Concord\AbstractBoxServiceProvider;

class ModuleServiceProvider extends AbstractBoxServiceProvider
{
    public function register()
    {
        parent::register();

        $this->app->register(AuthServiceProvider::class);
        $this->app->register(\Lavary\Menu\ServiceProvider::class);
        $this->app->concord->registerAlias('Menu', \Lavary\Menu\Facade::class);

        $this->registerScaffoldCommand();

        $this->app->bind(MenuBuilderInterface::class, $this->config('menu.builder.class'));

        $this->app->when($this->config('menu.builder.class'))
            ->needs('$menu')
            ->give($this->app->make('menu'));
    }

    public function boot()
    {
        $menuBuilder = $this->app->make(MenuBuilderInterface::class);
        $menuBuilder->build($this->config('menu.name'));
    }

    /**
     * Register the appshell:scaffold command.
     */
    protected function registerScaffoldCommand()
    {
        $this->app->singleton('command.appshell.scaffold', function ($app) {
            return new ScaffoldCommand();
        });

        $this->commands('command.appshell.scaffold');
    }


}