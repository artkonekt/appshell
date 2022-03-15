<?php

declare(strict_types=1);

/**
 * Contains the DefaultCurrency class.
 *
 * @copyright   Copyright (c) 2022 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2022-03-15
 *
 */

namespace Konekt\AppShell\Settings;

use Konekt\AppShell\Traits\AccessesAppShellConfig;
use Konekt\Gears\Contracts\Setting;

class DefaultCurrency implements Setting
{
    use AccessesAppShellConfig;

    public const KEY = 'appshell.default.currency';

    private static ?array $currencies = null;

    public function key()
    {
        return self::KEY;
    }

    public function default()
    {
        return 'USD';
    }

    public function isAllowed()
    {
        return true;
    }

    public function options()
    {
        if (null === self::$currencies) {
            self::$currencies = json_decode(file_get_contents(dirname(__DIR__) . '/resources/database/ currencies.json'), true);
        }

        return self::$currencies;
    }

    public function syncWithConfig()
    {
        return false;
    }
}

