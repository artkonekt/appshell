<?php

declare(strict_types=1);

/**
 * Contains the FontAwesome6ProIconTheme class.
 *
 * @copyright   Copyright (c) 2022 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2022-09-02
 *
 */

namespace Konekt\AppShell\Icons;

use Konekt\AppShell\Contracts\IconTheme;
use Konekt\AppShell\Theme\ThemeColor;

class FontAwesome6ProIconTheme implements IconTheme
{
    use HasIconMap;
    use HasFallbackIcon;

    public const ID = 'font-awesome6-pro';

    private const FA_ANIMATION_TYPES = ['beat', 'beat-fade', 'bounce', 'flip', 'shake', 'spin'];
    private const FA_PRO_STYLES = ['solid', 'regular', 'light', 'thin', 'duotone'];
    private const DEFAULT_STYLE = 'regular';

    private ?string $kitCode;

    private string $iconStyle;

    private static string $fallbackIcon = 'caret-right';

    private static array $icons = [
        AppShellIcons::USERS => 'people-group',
        AppShellIcons::USER => 'person',
        AppShellIcons::USER_ACTIVE => 'person-circle-check',
        AppShellIcons::USER_INACTIVE => 'person-circle-xmark',
        AppShellIcons::CUSTOMERS => 'address-card',
        AppShellIcons::CUSTOMER => 'id-badge',
        AppShellIcons::WARNING => 'brake-warning',
        AppShellIcons::ACTIVE => 'wave-pulse',
        AppShellIcons::INACTIVE => 'skull',
        AppShellIcons::CHECK => 'circle-check',
        AppShellIcons::CROSS => 'circle-xmark',
        AppShellIcons::INFO => 'square-info',
        AppShellIcons::HELP => 'square-question',
        AppShellIcons::EMAIL => 'envelopes',
        AppShellIcons::ORGANIZATION => 'building-user',
        AppShellIcons::PASSWORD => 'key-skeleton',
        AppShellIcons::MONEY => 'money-check-dollar',
        AppShellIcons::CALENDAR => 'calendar-lines',
        AppShellIcons::MALE => 'mars',
        AppShellIcons::FEMALE => 'venus',
        AppShellIcons::SMILEY_GLAD => 'face-smile-relaxed',
        AppShellIcons::SMILEY_SAD => 'face-disappointed',
        AppShellIcons::MORE_ITEMS => 'ellipsis-vertical',
        AppShellIcons::PLUS => 'plus',
        AppShellIcons::MINUS => 'minus',
        AppShellIcons::EDIT => 'pencil',
        AppShellIcons::DELETE => 'trash',
        AppShellIcons::TAG => 'hashtag',
        AppShellIcons::COLOR => 'palette',
        AppShellIcons::SORT => 'bars-sort',
        AppShellIcons::SORT_ASC => 'arrow-down-short-wide',
        AppShellIcons::SORT_DESC => 'arrow-down-wide-short',
        AppShellIcons::SETTINGS => 'gears',
        AppShellIcons::SECURITY => 'shield-halved',
        AppShellIcons::STAR => 'stars',
        AppShellIcons::TIME => 'timer',
        AppShellIcons::TAX => 'droplet-percent',
        AppShellIcons::QUICK_LINKS => 'bolt',
        AppShellIcons::HAMBURGER => 'bars-staggered',
        AppShellIcons::LINK => 'link-simple',
        AppShellIcons::IMAGE => 'images',
        AppShellIcons::CHEVRON_RIGHT => 'chevron-right',
        AppShellIcons::CHEVRON_LEFT => 'chevron-left',
        AppShellIcons::FILTERS => 'sliders-up',
        AppShellIcons::SEARCH => 'magnifying-glass',
        AppShellIcons::SPINNER => 'spinner',
        AppShellIcons::PLUG => 'plug',
        AppShellIcons::UPLOAD => 'cloud-upload',
        AppShellIcons::DOWNLOAD => 'cloud-download',
        AppShellIcons::FOLDER => 'folder-open',
        AppShellIcons::FILE => 'file',
        AppShellIcons::COMMENT => 'comment-lines',
        AppShellIcons::GLOBE => 'earth-africa',
        AppShellIcons::FLAG => 'flag-swallowtail',
    ];

    public function __construct()
    {
        $this->kitCode = config('konekt.app_shell.icons.fa6_pro.kit_code');
        $this->iconStyle = config('konekt.app_shell.icons.fa6_pro.icon_style', self::DEFAULT_STYLE);
        if (!in_array($this->iconStyle, self::FA_PRO_STYLES)) {
            $this->iconStyle = self::DEFAULT_STYLE;
        }
    }

    public static function getName(): string
    {
        return 'Font Awesome 6 Pro';
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

        if (null !== $this->kitCode) {
            return $this->kitCode;
        }

        if (function_exists('flash')) {
            flash()->warning(__('Font Awesome Pro 6 Kit code is missing from config. Falling back to free version.'));
        }

        return '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />';
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
            '<i class="fa-%s fa-%s %s fa-fw" %s></i>',
            $this->iconStyle,
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
