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

use Illuminate\Support\Facades\Facade;

/**
 * @method static mixed get($setting, $user = null)
 */
class Cart extends Facade
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
