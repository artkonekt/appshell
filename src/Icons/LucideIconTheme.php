<?php

declare(strict_types=1);

/**
 * Contains the LucideIconTheme class.
 *
 * @copyright   Copyright (c) 2024 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2024-04-04
 *
 */

namespace Konekt\AppShell\Icons;

use Konekt\AppShell\Contracts\IconTheme;
use Konekt\AppShell\Theme\ThemeColor;

class LucideIconTheme implements IconTheme
{
    use HasIconMap;
    use HasFallbackIcon;
    use CanAnimateIcons;

    public const ID = 'lucide';

    private static string $fallbackIcon = 'chevron-right';

    private static array $icons = [
        AppShellIcons::USERS => 'users-round',
        AppShellIcons::USER => 'user-round',
        AppShellIcons::USER_ACTIVE => 'user-round-check',
        AppShellIcons::USER_INACTIVE => 'user-round-x',
        AppShellIcons::CUSTOMERS => 'square-user',
        AppShellIcons::CUSTOMER => 'user',
        AppShellIcons::WARNING => 'shield-alert',
        AppShellIcons::ACTIVE => 'shield-check',
        AppShellIcons::INACTIVE => 'shield-x',
        AppShellIcons::CHECK => 'circle-check-big',
        AppShellIcons::CROSS => 'circle-x',
        AppShellIcons::INFO => 'badge-info',
        AppShellIcons::HELP => 'shield-question',
        AppShellIcons::EMAIL => 'mail',
        AppShellIcons::ORGANIZATION => 'building',
        AppShellIcons::PASSWORD => 'key',
        AppShellIcons::MONEY => 'coins',
        AppShellIcons::CALENDAR => 'calendar-range',
        AppShellIcons::MALE => 'leaf',
        AppShellIcons::FEMALE => 'flower',
        AppShellIcons::SMILEY_GLAD => 'smile',
        AppShellIcons::SMILEY_SAD => 'frown',
        AppShellIcons::MORE_ITEMS => 'chevron-down',
        AppShellIcons::PLUS => 'plus',
        AppShellIcons::MINUS => 'minus',
        AppShellIcons::EDIT => 'file-pen-line',
        AppShellIcons::DELETE => 'x',
        AppShellIcons::TAG => 'tag',
        AppShellIcons::COLOR => 'palette ',
        AppShellIcons::SORT => 'arrow-up-down',
        AppShellIcons::SORT_ASC => 'arrow-down-narrow-wide',
        AppShellIcons::SORT_DESC => 'arrow-down-wide-narrow',
        AppShellIcons::SETTINGS => 'settings',
        AppShellIcons::SECURITY => 'shield-half',
        AppShellIcons::STAR => 'sparkle',
        AppShellIcons::TIME => 'clock',
        AppShellIcons::TAX => 'stamp',
        AppShellIcons::QUICK_LINKS => 'ellipsis-vertical',
        AppShellIcons::HAMBURGER => 'menu',
        AppShellIcons::LINK => 'link-2',
        AppShellIcons::IMAGE => 'image',
        AppShellIcons::CHEVRON_RIGHT => 'chevron-right',
        AppShellIcons::CHEVRON_LEFT => 'chevron-left',
        AppShellIcons::FILTERS => 'sliders-horizontal',
        AppShellIcons::SEARCH => 'scan-search',
        AppShellIcons::SPINNER => 'disc-3',
        AppShellIcons::PLUG => 'plug-2',
        AppShellIcons::UPLOAD => 'cloud-upload',
        AppShellIcons::DOWNLOAD => 'cloud-download',
        AppShellIcons::FOLDER => 'folder-closed',
        AppShellIcons::FILE => 'file',
        AppShellIcons::COMMENT => 'message-square-text',
    ];

    public static function getName(): string
    {
        return 'Lucide';
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

        return
            '<script src="https://unpkg.com/lucide@latest"></script>' .
            '<script>document.addEventListener("DOMContentLoaded", () => lucide.createIcons());</script>' .
            $this->animationCss()
        ;
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
            '<i data-lucide="%s" style="width: 1em; height: 1em;" class="%s" %s></i>',
            $this->get($abstract),
            implode(' ', $classes),
            $attrString
        );
    }
}
