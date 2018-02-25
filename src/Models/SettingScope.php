<?php
/**
 * Contains the SettingScope enum class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-02-25
 *
 */


namespace Konekt\AppShell\Models;


use Konekt\AppShell\Contracts\SettingScope as SettingScopeContract;
use Konekt\Enum\Enum;

class SettingScope extends Enum implements SettingScopeContract
{
    const __default = self::APPLICATION;

    const APPLICATION = 'application';
    const USER        = 'user';

    protected static $labels = [];

    protected static function boot()
    {
        static::$labels = [
            self::APPLICATION => __('Application'),
            self::USER        => __('User')
        ];
    }

}
