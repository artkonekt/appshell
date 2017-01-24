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


use Konekt\Concord\AbstractBoxServiceProvider;
use Konekt\Concord\Contracts\ConcordInterface;

class ModuleServiceProvider extends AbstractBoxServiceProvider
{
    public function register()
    {
        parent::register();

        $this->app->register(\Lavary\Menu\ServiceProvider::class);
        $this->app->make(ConcordInterface::class)->registerFacade('Menu', \Lavary\Menu\Facade::class);
    }


}