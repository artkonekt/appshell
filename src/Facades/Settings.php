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

/**
 * @method static mixed get($setting, $user = null)
 * @method static Collection available()
 * @method static void register(Setting|string|array $setting)
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
