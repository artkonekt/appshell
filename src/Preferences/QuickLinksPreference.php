<?php
/**
 * Contains the QuickLinksPreference class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-09-09
 *
 */

namespace Konekt\AppShell\Preferences;

use Konekt\Gears\Contracts\Preference;

class QuickLinksPreference implements Preference
{
    public const KEY = 'appshell.quicklinks';

    public function key()
    {
        return self::KEY;
    }

    public function default()
    {
        return json_encode([]);
    }

    public function isAllowed()
    {
        return true;
    }

    public function options()
    {
        return [];
    }
}
