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
        AppShellIcons::TAX => 'tax',
        AppShellIcons::QUICK_LINKS => 'windmill',
        AppShellIcons::HAMBURGER => 'menu-2',
        AppShellIcons::LINK => 'link',
        AppShellIcons::IMAGE => 'photo',
        AppShellIcons::CHEVRON_RIGHT => 'chevron-right',
        AppShellIcons::CHEVRON_LEFT => 'chevron-left',
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

        return '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tabler-icons/1.34.0/iconfont/tabler-icons.min.css" integrity="sha512-mWpmj8VqORtX/CTiI5Mypqx75NqtF3Ddym7C94bpi8d8nVW46OlJbtdGDcGsQDZ4VJARIgMLbzm8zyN1Ies3Qw==" crossorigin="anonymous" />';
    }

    public function render(string $abstract, ThemeColor $color, array $attributes = []): string
    {
        $classes = [];

        if (null !== $color->value()) {
            $classes[] = "text-" . $color->value();
        }

        if (isset($attributes['class'])) {
            array_merge($classes, explode(' ', $attributes['class']));
            unset($attributes['class']);
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
