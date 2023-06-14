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
    protected static function isThemeColor(string $color): bool
    {
        return helper('color')->isThemeColor($color);
    }

    protected static function needsWhiteText(string $bgColor): bool
    {
        return helper('color')->needsWhiteText($bgColor);
    }

    protected static function colorAsHex(string $color): string
    {
        return helper('color')->colorAsHex($color);
    }
}
