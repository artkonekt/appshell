<?php

declare(strict_types=1);

/**
 * Contains the EnumIcons class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-10-02
 *
 */

namespace Konekt\AppShell;

use Illuminate\Support\Arr;
use Konekt\Enum\Enum;

final class EnumIcons
{
    private static array $map = [];

    /**
     * Register icon mapping for a specific enum class
     */
    public static function registerEnumIcons(string $enumClass, array $icons): void
    {
        self::$map[$enumClass] = $icons;
    }

    /**
     * Returns the abstract icon name for the given enum instance
     */
    public static function iconOf(Enum $enum): string
    {
        return Arr::get(self::$map, get_class($enum) . '.' . $enum->value(), '');
    }
}
