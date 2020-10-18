<?php

declare(strict_types=1);

/**
 * Contains the HasIconMap trait.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-10-18
 *
 */

namespace Konekt\AppShell\Icons;

trait HasIconMap
{
    /*
     * Define this property in the concrete class, and populate with icon mapping:
    private static array $icons = [
        AppShellIcons::USER => 'account-circle',
        //... etc
    ];
    */

    public static function extend(string $abstract, string $concrete): void
    {
        self::$icons[$abstract] = $concrete;
    }
}
