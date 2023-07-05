<?php

declare(strict_types=1);

/**
 * Contains the TablerIconTheme class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-10-18
 *
 */

namespace Konekt\AppShell\Icons;

use Konekt\AppShell\Contracts\IconTheme;
use Konekt\AppShell\Theme\ThemeColor;

class TablerIconTheme implements IconTheme
{
    use HasIconMap;
    use HasFallbackIcon;
    use CanAnimateIcons;

    public const ID = 'tablericons';

    private static string $fallbackIcon = 'chevron-right';

    private static array $icons = [
        AppShellIcons::USERS => 'users',
        AppShellIcons::USER => 'user',
        AppShellIcons::USER_ACTIVE => 'user-check',
        AppShellIcons::USER_INACTIVE => 'user-x',
        AppShellIcons::CUSTOMERS => 'id',
        AppShellIcons::CUSTOMER => 'id',
        AppShellIcons::WARNING => 'alert-octagon',
        AppShellIcons::ACTIVE => 'arrow-right-circle',
        AppShellIcons::INACTIVE => 'circle-x',
        AppShellIcons::CHECK => 'check',
        AppShellIcons::CROSS => 'x',
        AppShellIcons::INFO => 'info-square',
        AppShellIcons::HELP => 'help',
        AppShellIcons::EMAIL => 'mail',
        AppShellIcons::ORGANIZATION => 'building',
        AppShellIcons::PASSWORD => 'key',
        AppShellIcons::MONEY => 'currency-dollar',
        AppShellIcons::CALENDAR => 'calendar',
        AppShellIcons::MALE => 'man',
        AppShellIcons::FEMALE => 'woman',
        AppShellIcons::SMILEY_GLAD => 'mood-smile',
        AppShellIcons::SMILEY_SAD => 'mood-confuzed',
        AppShellIcons::MORE_ITEMS => 'dots-vertical',
        AppShellIcons::PLUS => 'plus',
        AppShellIcons::MINUS => 'minus',
        AppShellIcons::EDIT => 'pencil',
        AppShellIcons::DELETE => 'x',
        AppShellIcons::TAG => 'tag',
        AppShellIcons::COLOR => 'color-swatch',
        AppShellIcons::SORT => 'sort-amount-asc',
        AppShellIcons::SORT_ASC => 'sort-ascending',
        AppShellIcons::SORT_DESC => 'sort-descending',
        AppShellIcons::SETTINGS => 'settings',
        AppShellIcons::SECURITY => 'shield-check',
        AppShellIcons::STAR => 'star',
        AppShellIcons::TIME => 'history',
        AppShellIcons::TAX => 'receipt-tax',
        AppShellIcons::QUICK_LINKS => 'windmill',
        AppShellIcons::HAMBURGER => 'menu-2',
        AppShellIcons::LINK => 'link',
        AppShellIcons::IMAGE => 'photo',
        AppShellIcons::CHEVRON_RIGHT => 'chevron-right',
        AppShellIcons::CHEVRON_LEFT => 'chevron-left',
        AppShellIcons::FILTERS => 'adjustments',
        AppShellIcons::SEARCH => 'search',
        AppShellIcons::SPINNER => 'rotate-clockwise-2',
        AppShellIcons::PLUG => 'plug',
        AppShellIcons::UPLOAD => 'cloud-upload',
        AppShellIcons::FOLDER => 'folder',
        AppShellIcons::FILE => 'file',
    ];

    public static function getName(): string
    {
        return 'Tabler Icons';
    }

    public function get(string $abstract): string
    {
        return self::$icons[$abstract] ?? self::getFallbackIcon();
    }

    public function assets(string $location = 'header'): string
    {
        if ('header' !== $location) {
            return '';
        }

        return '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons@latest/iconfont/tabler-icons.min.css">'
            . $this->animationCss('display:inline-block;');
    }

    public function render(string $abstract, ThemeColor $color, array $attributes = []): string
    {
        $classes = [];

        if (null !== $color->value()) {
            $classes[] = "text-" . $color->value();
        }

        if (isset($attributes['class'])) {
            $classes = array_merge($classes, explode(' ', $attributes['class']));
            unset($attributes['class']);
        }

        if (isset($attributes['animate']) && boolval($attributes['animate'])) {
            $classes = array_merge($classes, [self::$animatedIconClass]);
            unset($attributes['animate']);
        }

        $attrString = implode(
            ' ',
            array_map(
                function ($v, $k) {
                    return "$k=\"$v\"";
                },
                $attributes,
                array_keys($attributes)
            )
        );

        return sprintf(
            '<i class="ti ti-%s %s" %s></i>',
            $this->get($abstract),
            implode(' ', $classes),
            $attrString
        );
    }
}
