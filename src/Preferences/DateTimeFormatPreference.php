<?php
/**
 * Contains the DateTimeFormatPreference class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-09-07
 *
 */

namespace Konekt\AppShell\Preferences;

use Konekt\AppShell\Traits\AccessesAppShellConfig;
use Konekt\Gears\Contracts\Preference;

class DateTimeFormatPreference implements Preference
{
    use AccessesAppShellConfig;
    use GeneratesSampleDateTimeOptions;

    public const KEY     = 'appshell.ui.datetime_format';
    public const DEFAULT = 'Y-m-d H:i';

    /** @var array|null */
    private $options;

    public function key()
    {
        return self::KEY;
    }

    public function default()
    {
        return $this->config('formats.datetime.default', self::DEFAULT);
    }

    public function isAllowed()
    {
        return true;
    }

    public function options()
    {
        if (null === $this->options) {
            $this->options = $this->generateOptions('formats.datetime.options');
        }

        return $this->options;
    }
}
