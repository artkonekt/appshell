<?php

declare(strict_types=1);

/**
 * Contains the UiServiceProvider class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-10-19
 *
 */

namespace Konekt\AppShell\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Konekt\AppShell\EnumIcons;
use Konekt\AppShell\Icons\FontAwesomeIconTheme;
use Konekt\AppShell\Icons\LineIconsTheme;
use Konekt\AppShell\Icons\ZmdiAppShellIcons;
use Konekt\AppShell\Icons\ZmdiIconTheme;
use Konekt\AppShell\IconThemes;
use Konekt\AppShell\Settings\UiIconThemeSetting;
use Konekt\AppShell\Settings\UiThemeSetting;
use Konekt\AppShell\Theme\AppShellTheme;
use Konekt\AppShell\Themes;
use Konekt\AppShell\Traits\AccessesAppShellConfig;
use Konekt\AppShell\Ui\UiConfig;
use Konekt\Customer\Models\CustomerType;
use Konekt\Customer\Models\CustomerTypeProxy;
use Konekt\Gears\Facades\Settings;

class UiServiceProvider extends ServiceProvider
{
    use AccessesAppShellConfig;

    public function register()
    {
        Themes::add(AppShellTheme::ID, AppShellTheme::class);
        IconThemes::add(ZmdiIconTheme::ID, ZmdiIconTheme::class);
        IconThemes::add(FontAwesomeIconTheme::ID, FontAwesomeIconTheme::class);
        IconThemes::add(LineIconsTheme::ID, LineIconsTheme::class);
        //Tabler icons disabled until https://github.com/tabler/tabler-icons/issues/13 gets fixed
        //IconThemes::add(TablerIconTheme::ID, TablerIconTheme::class);

        $this->app->singleton('appshell.icon_theme', function () {
            return IconThemes::make(Settings::get(UiIconThemeSetting::KEY));
        });

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
        $this->registerEnumIcons();

        View::share('appshell', new UiConfig($this->config('ui')));
    }

    private function registerEnumIcons()
    {
        EnumIcons::registerEnumIcons(
            CustomerTypeProxy::enumClass(),
            [
                CustomerType::ORGANIZATION => 'organization',
                CustomerType::INDIVIDUAL   => 'user'
            ]
        );
    }
}
