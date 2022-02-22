<?php

declare(strict_types=1);

/**
 * Contains the FontAwesome6IconTheme class.
 *
 * @copyright   Copyright (c) 2022 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2022-02-22
 *
 */

namespace Konekt\AppShell\Icons;

use Konekt\AppShell\Contracts\IconTheme;
use Konekt\AppShell\Theme\ThemeColor;

class FontAwesome6IconTheme implements IconTheme
{
    use HasIconMap;
    use HasFallbackIcon;

    public const ID = 'font-awesome6';

    private const FA_ANIMATION_TYPES = ['beat', 'beat-fade', 'bounce', 'flip', 'shake', 'spin'];

    private static string $fallbackIcon = 'bookmark';

    private static array $icons = [
        AppShellIcons::USERS => 'user-group',
        AppShellIcons::USER => 'user',
        AppShellIcons::USER_ACTIVE => 'user-check',
        AppShellIcons::USER_INACTIVE => 'user-xmark',
        AppShellIcons::CUSTOMERS => 'address-card',
        AppShellIcons::CUSTOMER => 'id-badge',
        AppShellIcons::WARNING => 'triangle-exclamation',
        AppShellIcons::ACTIVE => 'circle-chevron-right',
        AppShellIcons::INACTIVE => 'circle-xmark',
        AppShellIcons::CHECK => 'check',
        AppShellIcons::CROSS => 'xmark',
        AppShellIcons::INFO => 'circle-info',
        AppShellIcons::HELP => 'circle-question',
        AppShellIcons::EMAIL => 'envelope',
        AppShellIcons::ORGANIZATION => 'city',
        AppShellIcons::PASSWORD => 'key',
        AppShellIcons::MONEY => 'money-check-dollar',
        AppShellIcons::CALENDAR => 'calendar-day',
        AppShellIcons::MALE => 'person',
        AppShellIcons::FEMALE => 'person-dress',
        AppShellIcons::SMILEY_GLAD => 'face-smile',
        AppShellIcons::SMILEY_SAD => 'face-frown',
        AppShellIcons::MORE_ITEMS => 'ellipsis-vertical',
        AppShellIcons::PLUS => 'plus',
        AppShellIcons::MINUS => 'minus',
        AppShellIcons::EDIT => 'pen',
        AppShellIcons::DELETE => 'xmark',
        AppShellIcons::TAG => 'tag',
        AppShellIcons::COLOR => 'palette',
        AppShellIcons::SORT => 'sort',
        AppShellIcons::SORT_ASC => 'arrow-up-wide-short',
        AppShellIcons::SORT_DESC => 'arrow-down-wide-short',
        AppShellIcons::SETTINGS => 'gear',
        AppShellIcons::SECURITY => 'shield',
        AppShellIcons::STAR => 'star',
        AppShellIcons::TIME => 'clock-rotate-left',
        AppShellIcons::TAX => 'scroll',
        AppShellIcons::QUICK_LINKS => 'bolt',
        AppShellIcons::HAMBURGER => 'bars-staggered',
        AppShellIcons::LINK => 'link',
        AppShellIcons::IMAGE => 'images',
        AppShellIcons::CHEVRON_RIGHT => 'chevron-right',
        AppShellIcons::CHEVRON_LEFT => 'chevron-left',
        AppShellIcons::FILTERS => 'sliders',
        AppShellIcons::SEARCH => 'magnifying-glass',
    ];

    public static function getName(): string
    {
        return 'Font Awesome 6 Icons';
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

        return '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />';
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

        if (isset($attributes['animate'])) {
            $classes = array_merge($classes, [$this->animationClass($attributes['animate'])]);
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
            '<i class="fa-solid fa-%s %s" %s></i>',
            $this->get($abstract),
            implode(' ', $classes),
            $attrString
        );
    }

    private function animationClass($definition): string
    {
        if (false === boolval($definition)) {
            return '';
        }

        $result = 'fa-spin';

        if (is_string($definition) && in_array(strtolower($definition), static::FA_ANIMATION_TYPES)) {
            $result = "fa-$definition";
        }

        return $result;
    }
}
