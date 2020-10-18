<?php

declare(strict_types=1);

/**
 * Contains the IconTheme interface.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-10-18
 *
 */

namespace Konekt\AppShell\Contracts;

use Konekt\AppShell\Theme\ThemeColor;

interface IconTheme
{
    /*
     * Returns the name of the Icon Theme
     */
    public static function getName(): string;

    /*
     * Allows to add or overwrite mappings between abstract and concrete icons
     */
    public static function extend(string $abstract, string $concrete): void;

    /*
     * Returns the concrete icon name in theme theme based on abstract name
     * Eg.: 'users' => 'user-friends'
     */
    public function get(string $abstract): string;

    /*
     * Returns the HTML snippet required to render the icon tag
     */
    public function render(string $abstract, ThemeColor $color, array $attributes = []): string;

    /*
     * Returns the HTML snippets (stylsheets and/or script) required
     * to be included in the layout in order to import the assets
     * needed in order the icons to be rendered. CDN or local.
     */
    public function assets(string $location = 'header'): string;
}
