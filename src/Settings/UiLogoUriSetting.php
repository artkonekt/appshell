<?php

declare(strict_types=1);

/**
 * Contains the UiLogoUriSetting class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-10-17
 *
 */

namespace Konekt\AppShell\Settings;

use Konekt\AppShell\Traits\AccessesAppShellConfig;
use Konekt\Gears\Contracts\Setting;

class UiLogoUriSetting implements Setting
{
    use AccessesAppShellConfig;

    public const KEY = 'appshell.ui.logo_uri';

    public function key()
    {
        return self::KEY;
    }

    public function default()
    {
        return $this->config('ui.logo_uri');
    }

    public function isAllowed()
    {
        return true;
    }

    public function options()
    {
        return null;
    }

    public function syncWithConfig()
    {
        return false;
    }
}
