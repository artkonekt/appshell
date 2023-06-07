<?php

declare(strict_types=1);

/**
 * Contains the ThemeServiceProvider class.
 *
 * @copyright   Copyright (c) 2022 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2022-04-27
 *
 */

namespace Konekt\AppShell\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Konekt\AppShell\Settings\UiThemeSetting;
use Konekt\AppShell\Theme\AppShellTheme;
use Konekt\AppShell\Theme\TridentTheme;
use Konekt\AppShell\Themes;
use Konekt\AppShell\Traits\AccessesAppShellConfig;
use Konekt\Gears\Facades\Settings;

class ThemeServiceProvider extends ServiceProvider
{
    use AccessesAppShellConfig;

    public function register()
    {
        Themes::add(AppShellTheme::ID, AppShellTheme::class);
        Themes::add(TridentTheme::ID, TridentTheme::class);

        $this->app->singleton('appshell.theme', function () {
            $theme = Themes::make(Settings::get(UiThemeSetting::KEY));
            $this->app['config']->set('breadcrumbs.view', $theme->viewNamespace() . '::widgets.breadcrumbs');

            return $theme;
        });
    }

    public function boot()
    {
        if (!$this->config('ui.theme')) {
            config(['konekt.app_shell.ui.theme' => AppShellTheme::ID]);
        }

        // Tells Laravel to take AppShell components from the current theme
        Blade::componentNamespace(theme()->componentNamespace(), 'appshell');
    }
}
