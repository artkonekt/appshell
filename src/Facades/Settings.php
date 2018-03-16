<?php
/**
 * Contains the Settings facade class.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-03-10
 *
 */


namespace Konekt\AppShell\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Konekt\AppShell\Contracts\Setting;
use Konekt\AppShell\Contracts\SettingsGroup;
use Konekt\AppShell\Contracts\SettingsTab;

/**
 * @method static mixed get($setting, $user = null)
 * @method static Collection available()
 * @method static Collection tabs()
 * @method static void registerTab(SettingsTab $tab)
 * @method static void registerGroup(SettingsGroup $group, $tab = null)
 * @method static void registerSetting(Setting|string|array $setting)
 * @method static Collection forApplication()
 * @method static Collection forUser()
 */
class Settings extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'appshell.settings';
    }
}
