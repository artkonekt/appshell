<?php

declare(strict_types=1);

/**
 * Contains the HasDefaultIcon trait.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-10-18
 *
 */

namespace Konekt\AppShell\Icons;

trait HasFallbackIcon
{
    // Define the fallback icon in your concrete class:
    // private static string $fallbackIcon = 'theme-fallback-icon-name-here';

    private static function getFallbackIcon(): string
    {
        return self::$fallbackIcon;
    }
}
