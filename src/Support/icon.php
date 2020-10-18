<?php

/**
 * Icon Helper Functions for AppShell Icon Themes
 * They are intended to be uses in Blade Views
 * In Backend code use app(`appshell.icon_theme`)
 */

use Konekt\AppShell\Contracts\IconTheme;
use Konekt\AppShell\Theme\ThemeColor;

/**
 * Renders an icon using the selected Icon theme
 */
function icon(string $name, string $color = null, array $attributes = []): string
{
    return icon_theme()->render($name, ThemeColor::create($color), $attributes);
}

function icon_theme_assets(string $location = 'header'): string
{
    return icon_theme()->assets($location);
}

function icon_theme(): IconTheme
{
    return app('appshell.icon_theme');
}
