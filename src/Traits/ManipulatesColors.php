<?php

declare(strict_types=1);

/**
 * Contains the ManipulatesColors trait.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-01-10
 *
 */

namespace Konekt\AppShell\Traits;

use Konekt\AppShell\Theme\ThemeColor;

trait ManipulatesColors
{
    protected static function isThemeColor(string $string): bool
    {
        return ThemeColor::has($string);
    }

    protected static function needsWhiteText(string $bgColor): bool
    {
        return helper('color')->canBeReadTogether(self::colorAsHex($bgColor), '#ffffff');
    }

    protected static function colorAsHex(string $color): string
    {
        return self::isThemeColor($color) ? theme()->themeColorToHex($color) : $color;
    }
}
