<?php

declare(strict_types=1);

/**
 * Contains the UiConfig class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-10-17
 *
 */

namespace Konekt\AppShell\Ui;

use Konekt\AppShell\Settings\UiLogoUriSetting;
use Konekt\AppShell\Settings\UiNameSetting;
use Konekt\AppShell\Settings\UiThemeSetting;
use Konekt\Gears\Facades\Settings;

/**
 * @property-read string $name
 * @property-read string $url
 */
final class UiConfig
{
    /** property name => Setting name */
    private static array $settingBased = [
        'name'    => UiNameSetting::KEY,
        'theme'   => UiThemeSetting::KEY,
        'logoUri' => UiLogoUriSetting::KEY
    ];

    private array $data;

    public function __construct(array $uiConfiguration)
    {
        $this->data = $uiConfiguration;
        $this->fixMissingDefaults();
    }

    public function __get(string $name)
    {
        if (isset(self::$settingBased[$name])) {
            return Settings::get(self::$settingBased[$name]);
        }

        return $this->data[$name];
    }

    private function fixMissingDefaults(): void
    {
        if (!isset($this->data['routes'])) {
            $this->data['routes']['login']  = 'login';
            $this->data['routes']['logout'] = 'logout';
        }

        if (!isset($this->data['quick_links'])) {
            $this->data['quick_links']['enabled'] = true;
        }
    }
}
