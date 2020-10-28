<?php

declare(strict_types=1);

/**
 * Contains the LineIconsTheme class.
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

class LineIconsTheme implements IconTheme
{
    use HasIconMap;
    use HasFallbackIcon;

    public const ID = 'lineicons';

    private static string $fallbackIcon = 'chevron-right';

    private static array $icons = [
        AppShellIcons::USERS => 'users',
        AppShellIcons::USER => 'user',
        AppShellIcons::USER_ACTIVE => 'user',
        AppShellIcons::USER_INACTIVE => 'user',
        AppShellIcons::CUSTOMERS => 'consulting',
        AppShellIcons::CUSTOMER => 'target-customer',
        AppShellIcons::WARNING => 'warning',
        AppShellIcons::ACTIVE => 'chevron-right-circle',
        AppShellIcons::INACTIVE => 'cross-circle',
        AppShellIcons::CHECK => 'checkmark',
        AppShellIcons::CROSS => 'close',
        AppShellIcons::INFO => 'information',
        AppShellIcons::HELP => 'question-circle',
        AppShellIcons::EMAIL => 'envelope',
        AppShellIcons::ORGANIZATION => 'apartment',
        AppShellIcons::PASSWORD => 'key',
        AppShellIcons::MONEY => 'money-protection',
        AppShellIcons::CALENDAR => 'calendar',
        AppShellIcons::MALE => 'leaf',
        AppShellIcons::FEMALE => 'flower',
        AppShellIcons::SMILEY_GLAD => 'emoji-friendly',
        AppShellIcons::SMILEY_SAD => 'emoji-suspect',
        AppShellIcons::MORE_ITEMS => 'chevron-down',
        AppShellIcons::PLUS => 'plus',
        AppShellIcons::MINUS => 'minus',
        AppShellIcons::EDIT => 'pencil',
        AppShellIcons::DELETE => 'close',
        AppShellIcons::TAG => 'tag',
        AppShellIcons::COLOR => 'pallet ',
        AppShellIcons::SORT => 'sort-amount-asc',
        AppShellIcons::SORT_ASC => 'sort-amount-asc',
        AppShellIcons::SORT_DESC => 'sort-amount-dsc',
        AppShellIcons::SETTINGS => 'cog',
        AppShellIcons::SECURITY => 'shield',
        AppShellIcons::STAR => 'star',
        AppShellIcons::TIME => 'timer',
        AppShellIcons::TAX => 'stamp',
        AppShellIcons::QUICK_LINKS => 'bolt-alt',
        AppShellIcons::HAMBURGER => 'menu',
        AppShellIcons::LINK => 'link',
        AppShellIcons::IMAGE => 'image',
        AppShellIcons::CHEVRON_RIGHT => 'chevron-right',
        AppShellIcons::CHEVRON_LEFT => 'chevron-left',
    ];

    public static function getName(): string
    {
        return 'Lineicons 2';
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

        return '<link href="https://cdn.lineicons.com/2.0/LineIcons.css" rel="stylesheet">';
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
            '<i class="lni lni-%s %s" %s></i>',
            $this->get($abstract),
            implode(' ', $classes),
            $attrString
        );
    }
}
