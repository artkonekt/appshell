<?php
/**
 * Contains the AppName setting class.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-03-10
 *
 */

namespace Konekt\AppShell\Settings\BuiltIn;

use Konekt\AppShell\Contracts\Setting;

class AppName implements Setting
{
    /**
     * @inheritDoc
     */
    public static function key()
    {
        return 'konekt.app_shell.ui.name';
    }

    /**
     * @inheritDoc
     */
    public function label()
    {
        return __('Name of the application');
    }

    /**
     * @inheritDoc
     */
    public function default()
    {
        return config('konekt.app_shell.ui.name');
    }

    /**
     * @inheritDoc
     */
    public function permission()
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function role()
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function options()
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function syncWithConfig()
    {
        return true;
    }
}
