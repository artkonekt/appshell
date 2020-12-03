<?php

declare(strict_types=1);

/**
 * Contains the EmailDriverSetting class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-12-03
 *
 */

namespace Konekt\AppShell\Settings\Email;

use Konekt\AppShell\Models\EmailDriver;
use Konekt\Gears\Contracts\Setting;

class EmailDriverSetting implements Setting
{
    public const KEY = 'appshell.email.driver';

    public function key()
    {
        return self::KEY;
    }

    public function default()
    {
        return EmailDriver::defaultValue();
    }

    public function isAllowed()
    {
        return true;
    }

    public function options()
    {
        return EmailDriver::choices();
    }

    public function syncWithConfig()
    {
        return false;
    }
}
