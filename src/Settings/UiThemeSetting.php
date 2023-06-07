<?php

declare(strict_types=1);

/**
 * Contains the UiThemeSetting class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-10-17
 *
 */

namespace Konekt\AppShell\Settings;

use Konekt\AppShell\Theme\AppShellTheme;
use Konekt\AppShell\Themes;
use Konekt\AppShell\Traits\AccessesAppShellConfig;
use Konekt\Gears\Contracts\Setting;

class UiThemeSetting implements Setting
{
    use AccessesAppShellConfig;

    public const KEY = 'appshell.ui.theme';

    public function key()
    {
        return self::KEY;
    }

    public function default()
    {
        return $this->config('ui.theme', AppShellTheme::ID);
    }

    public function isAllowed()
    {
        return true;
    }

    public function options()
    {
        return Themes::choices();
    }

    public function syncWithConfig()
    {
        return false;
    }
}
