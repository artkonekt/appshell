<?php

declare(strict_types=1);

/**
 * Contains the EnumColors class.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-03-10
 *
 */

namespace Konekt\AppShell;

use Illuminate\Support\Arr;
use Konekt\AppShell\Theme\ThemeColor;
use Konekt\Enum\Enum;

final class EnumColors
{
    private static array $map = [];

    public static function registerEnumColor(string $enumClass, array $colors): void
    {
        self::$map[$enumClass] = $colors;
    }

    /**
     * Returns the abstract icon name for the given enum instance
     */
    public static function colorOf(Enum $enum): ThemeColor|string
    {
        return Arr::get(self::$map, get_class($enum) . '.' . $enum->value(), ThemeColor::NONE());
    }
}
