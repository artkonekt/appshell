<?php

declare(strict_types=1);

/**
 * Contains the CanAnimateIcons trait.
 *
 * @copyright   Copyright (c) 2022 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2022-02-22
 *
 */

namespace Konekt\AppShell\Icons;

trait CanAnimateIcons
{
    protected static string $animatedIconClass = 'icon-appshell-animated';

    private function animationCss(): string
    {
        return '.' . static::$animatedIconClass . '{animation:appshellspin 4s linear infinite;}'
            . '@keyframes appshellspin { 100% { -webkit-transform: rotate(360deg); transform:rotate(360deg); }}';
    }
}
