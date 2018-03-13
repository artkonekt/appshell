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
use Konekt\AppShell\Contracts\SettingScope;
use Konekt\AppShell\Models\SettingScopeProxy;

class AppName implements Setting
{
    /** @var SettingScope */
    private $scope;

    public function __construct()
    {
        $this->scope = SettingScopeProxy::APPLICATION();
    }

    /**
     * @inheritDoc
     */
    public function key()
    {
        return 'appshell.ui.app_name';
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
    public function scope(): SettingScope
    {
        return $this->scope;
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
        return false;
    }


}
