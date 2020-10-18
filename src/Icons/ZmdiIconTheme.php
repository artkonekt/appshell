<?php

declare(strict_types=1);

/**
 * Contains the ZmdiIconTheme class.
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

class ZmdiIconTheme implements IconTheme
{
    use HasIconMap;
    use HasFallbackIcon;

    public const ID = 'zmdi';

    private static string $fallbackIcon = 'label-alt-outline';

    private static array $icons = [
        AppShellIcons::USERS => 'accounts',
        AppShellIcons::USER => 'account-circle',
        AppShellIcons::USER_ACTIVE => 'account-circle',
        AppShellIcons::USER_INACTIVE => 'account-o',
        AppShellIcons::CUSTOMERS => 'accounts-list',
        AppShellIcons::WARNING => 'alert-triangle',
        AppShellIcons::CHECK => 'check',
        AppShellIcons::INFO => 'info',
        AppShellIcons::HELP => 'help',
        AppShellIcons::EMAIL => 'email',
        AppShellIcons::ORGANIZATION => 'city',
        AppShellIcons::PASSWORD => 'lock',
        AppShellIcons::SMILEY_GLAD => 'mood',
        AppShellIcons::SMILEY_SAD => 'mood-bad',
        AppShellIcons::MORE_ITEMS => 'more-vert',
        AppShellIcons::PLUS => 'plus',
        AppShellIcons::SETTINGS => 'settings',
        AppShellIcons::SECURITY => 'shield-security',
        AppShellIcons::STAR => 'star-circle',
        AppShellIcons::TIME => 'time-countdown',
        AppShellIcons::TAX => 'toll',
        AppShellIcons::QUICK_LINKS => 'toys',
    ];

    public static function getName(): string
    {
        return 'ZMDI Material Icons';
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

        return '<link href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css" media="all" type="text/css" rel="stylesheet" integrity="sha256-3sPp8BkKUE7QyPSl6VfBByBroQbKxKG7tsusY2mhbVY=" crossorigin="anonymous" />';
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
            '<i class="zmdi zmdi-%s %s" %s></i>',
            $this->get($abstract),
            implode(' ', $classes),
            $attrString
        );
    }
}
