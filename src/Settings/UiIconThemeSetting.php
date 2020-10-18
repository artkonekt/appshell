<?php

declare(strict_types=1);

/**
 * Contains the UiIconThemeSetting class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-10-18
 *
 */

namespace Konekt\AppShell\Settings;

use Konekt\AppShell\Icons\ZmdiIconTheme;
use Konekt\AppShell\IconThemes;
use Konekt\AppShell\Traits\AccessesAppShellConfig;
use Konekt\Gears\Contracts\Setting;

class UiIconThemeSetting implements Setting
{
    use AccessesAppShellConfig;

    public const KEY = 'appshell.ui.icon_theme';

    public function key()
    {
        return self::KEY;
    }

    public function default()
    {
        return $this->config('ui.icon_theme', ZmdiIconTheme::ID);
    }

    public function isAllowed()
    {
        return true;
    }

    public function options()
    {
        return IconThemes::choices();
    }

    public function syncWithConfig()
    {
        return false;
    }
}
