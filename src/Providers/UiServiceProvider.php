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
use Konekt\AppShell\Icons\FontAwesome6IconTheme;
use Konekt\AppShell\Icons\FontAwesomeIconTheme;
use Konekt\AppShell\Icons\LineIconsTheme;
use Konekt\AppShell\Icons\TablerIconTheme;
use Konekt\AppShell\Icons\ZmdiIconTheme;
use Konekt\AppShell\IconThemes;
use Konekt\AppShell\Settings\UiIconThemeSetting;
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
        IconThemes::add(ZmdiIconTheme::ID, ZmdiIconTheme::class);
        IconThemes::add(FontAwesomeIconTheme::ID, FontAwesomeIconTheme::class);
        IconThemes::add(FontAwesome6IconTheme::ID, FontAwesome6IconTheme::class);
        IconThemes::add(LineIconsTheme::ID, LineIconsTheme::class);
        IconThemes::add(TablerIconTheme::ID, TablerIconTheme::class);

        $this->app->singleton('appshell.icon_theme', function () {
            return IconThemes::make(Settings::get(UiIconThemeSetting::KEY));
        });
    }

    public function boot()
    {
        $this->registerEnumIcons();

        View::share('appshell', new UiConfig($this->config('ui')));
    }

    private function registerEnumIcons()
    {
        EnumIcons::registerEnumIcons(
            CustomerTypeProxy::enumClass(),
            [
                CustomerType::ORGANIZATION => 'organization',
                CustomerType::INDIVIDUAL => 'user'
            ]
        );
    }
}
