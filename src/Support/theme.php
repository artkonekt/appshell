<?php

/**
 * Theme Helper Functions for AppShell Themes
 * They're intended for use in Blade Views
 * In Backend code use `appshell.theme`
 */

use Konekt\AppShell\Contracts\Theme;

/**
 * Returns the widget component path according to
 * the selected theme. Eg. the `form.checkbox`
 * gives `appshell::widgets.form.checkbox`
 * If the selected theme is `blixy` it
 * is `blixy::widgets.form.checkbox`
 */
function theme_widget(string $widgetName): string
{
    return theme()->viewNamespace() . '::widgets.' . $widgetName;
}

function theme_color(?string $semanticColorName): string
{
    return theme()->themeColorToHex($semanticColorName ?? '');
}

function theme(): Theme
{
    return app('appshell.theme');
}
