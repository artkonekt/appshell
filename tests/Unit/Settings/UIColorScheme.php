<?php
/**
 * Contains the UIColorScheme class.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-02-25
 *
 */

namespace Konekt\AppShell\Tests\Unit\Settings;

use Konekt\AppShell\Contracts\Setting;
use Konekt\AppShell\Contracts\SettingScope;

class UIColorScheme implements Setting
{
    public function key()
    {
        return 'ui.color_scheme';
    }

    public function scope(): SettingScope
    {
        return \Konekt\AppShell\Models\SettingScope::USER();
    }

    public function default()
    {
        return 'red';
    }

    public function permission()
    {
        return null;
    }

    public function role()
    {
        return null;
    }

    public function options()
    {
        return ['red' => 'Red', 'blue' => 'Blue'];
    }

    public function syncWithConfig()
    {
        return false;
    }
}
