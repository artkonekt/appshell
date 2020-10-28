<?php

declare(strict_types=1);

/**
 * Contains the FontAwesomeIconTheme class.
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

class FontAwesomeIconTheme implements IconTheme
{
    use HasIconMap;
    use HasFallbackIcon;

    public const ID = 'font-awesome';

    private static string $fallbackIcon = 'bookmark';

    private static array $icons = [
        AppShellIcons::USERS => 'user-friends',
        AppShellIcons::USER => 'user',
        AppShellIcons::USER_ACTIVE => 'user',
        AppShellIcons::USER_INACTIVE => 'user-slash',
        AppShellIcons::CUSTOMERS => 'address-card',
        AppShellIcons::CUSTOMER => 'id-badge',
        AppShellIcons::WARNING => 'exclamation-triangle',
        AppShellIcons::ACTIVE => 'chevron-circle-right',
        AppShellIcons::INACTIVE => 'times-circle',
        AppShellIcons::CHECK => 'check',
        AppShellIcons::CROSS => 'times',
        AppShellIcons::INFO => 'info-circle',
        AppShellIcons::HELP => 'question-circle',
        AppShellIcons::EMAIL => 'envelope',
        AppShellIcons::ORGANIZATION => 'building',
        AppShellIcons::PASSWORD => 'key',
        AppShellIcons::MONEY => 'money-check-alt',
        AppShellIcons::CALENDAR => 'calendar-alt',
        AppShellIcons::MALE => 'male',
        AppShellIcons::FEMALE => 'female',
        AppShellIcons::SMILEY_GLAD => 'smile',
        AppShellIcons::SMILEY_SAD => 'sad-tear',
        AppShellIcons::MORE_ITEMS => 'ellipsis-v',
        AppShellIcons::PLUS => 'plus',
        AppShellIcons::MINUS => 'minus',
        AppShellIcons::EDIT => 'pen',
        AppShellIcons::DELETE => 'times',
        AppShellIcons::TAG => 'tag',
        AppShellIcons::COLOR => 'palette',
        AppShellIcons::SORT => 'sort',
        AppShellIcons::SORT_ASC => 'sort-amount-up',
        AppShellIcons::SORT_DESC => 'sort-amount-down',
        AppShellIcons::SETTINGS => 'cog',
        AppShellIcons::SECURITY => 'shield-alt',
        AppShellIcons::STAR => 'star',
        AppShellIcons::TIME => 'history',
        AppShellIcons::TAX => 'scroll',
        AppShellIcons::QUICK_LINKS => 'bolt',
        AppShellIcons::HAMBURGER => 'bars',
        AppShellIcons::LINK => 'link',
        AppShellIcons::IMAGE => 'images',
        AppShellIcons::CHEVRON_RIGHT => 'chevron-right',
        AppShellIcons::CHEVRON_LEFT => 'chevron-left',
    ];

    public static function getName(): string
    {
        return 'Font Awesome 5 Icons';
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

        return '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />';
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
            '<i class="fas fa-%s %s" %s></i>',
            $this->get($abstract),
            implode(' ', $classes),
            $attrString
        );
    }
}
