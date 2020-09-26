<?php
/**
 * Contains the DateFormatPreference class.
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

class DateFormatPreference implements Preference
{
    use AccessesAppShellConfig;
    use GeneratesSampleDateTimeOptions;

    public const KEY     = 'appshell.ui.date_format';
    public const DEFAULT = 'Y-m-d';

    /** @var array|null */
    private $options;

    public function key()
    {
        return self::KEY;
    }

    public function default()
    {
        return $this->config('formats.date.default', self::DEFAULT);
    }

    public function isAllowed()
    {
        return true;
    }

    public function options()
    {
        if (null === $this->options) {
            $this->options = $this->generateOptions('formats.date.options');
        }

        return $this->options;
    }
}
