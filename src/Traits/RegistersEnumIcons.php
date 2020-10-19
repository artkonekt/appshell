<?php

declare(strict_types=1);

/**
 * Contains the RegistersEnumIcons trait.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-10-19
 *
 */

namespace Konekt\AppShell\Traits;

use Konekt\AppShell\EnumIcons;

trait RegistersEnumIcons
{
    private function registerEnumIcons(): void
    {
        foreach ($this->enumIcons as $enumClass => $icons) {
            EnumIcons::registerEnumIcons($enumClass, $icons);
        }
    }
}
