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

use Konekt\AppShell\Contracts\Preference;
use Konekt\AppShell\Contracts\SettingScope;

class UIColorScheme implements Preference
{
    const DEFAULT = 'red';

    public static function key()
    {
        return 'ui.color_scheme';
    }

    public function default()
    {
        return self::DEFAULT;
    }

    /**
     * @inheritDoc
     */
    public function label()
    {
        return 'Color Scheme';
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
