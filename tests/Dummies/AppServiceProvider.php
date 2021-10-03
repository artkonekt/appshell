<?php

declare(strict_types=1);
/**
 * Contains the AppServiceProvider class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-09-24
 *
 */

namespace Konekt\AppShell\Tests\Dummies;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Demonstrates to add a custom setting to the default page, default group
        $settingsRegistry = $this->app->get('gears.settings_registry');
        $settingsRegistry->addByKey('appshell.ui.laika_the_astronaut');

        $settingsTreeBuilder = $this->app->get('appshell.settings_tree_builder');
        $settingsTreeBuilder->addSettingItem('general_app', ['text', ['label' => __('Laika the Astronaut')]], 'appshell.ui.laika_the_astronaut');
    }
}
