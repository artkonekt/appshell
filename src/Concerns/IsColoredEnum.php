<?php

declare(strict_types=1);

/**
 * Contains the IsColoredEnum trait.
 *
 * @copyright   Copyright (c) 2022 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2022-11-23
 *
 */

namespace Konekt\AppShell\Concerns;

use Konekt\AppShell\Theme\ThemeColor;

trait IsColoredEnum
{
    public function color(): ThemeColor
    {
        $defaultValue = property_exists($this, 'defaultColor') ? static::$defaultColor : null;

        if (property_exists(static::class, 'colors') && is_array(static::$colors)) {
            return ThemeColor::create(static::$colors[$this->value()] ?? $defaultValue);
        }

        return ThemeColor::create($defaultValue);
    }
}
