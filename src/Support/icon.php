<?php

declare(strict_types=1);

/**
 * Icon Helper Functions for AppShell Icon Themes
 * They are intended to be uses in Blade Views
 * In Backend code use app(`appshell.icon_theme`)
 */

use Konekt\AppShell\Contracts\IconTheme;
use Konekt\AppShell\EnumIcons;
use Konekt\AppShell\Theme\ThemeColor;
use Konekt\Enum\Enum;

/**
 * Returns the abstract icon name for a specific enum (value)
 */
function enum_icon(Enum $enum): string
{
    return EnumIcons::iconOf($enum);
}

/**
 * Renders an icon using the selected Icon theme
 */
function icon(string $name, string $color = null, array $attributes = []): string
{
    return icon_theme()->render($name, ThemeColor::create($color), $attributes);
}

/**
 * Returns the HTML snippets (css, js, fonts, etc) that loads
 * the required assets for the current Icon Theme. Snippet
 * to be injected in the layout at the passed $location
 */
function icon_theme_assets(string $location = 'header'): string
{
    return icon_theme()->assets($location);
}

/**
 * Returns the currently selected Icon Theme
 */
function icon_theme(): IconTheme
{
    return app('appshell.icon_theme');
}
