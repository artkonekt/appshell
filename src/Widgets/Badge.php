<?php

declare(strict_types=1);

/**
 * Contains the Badge class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-01-10
 *
 */

namespace Konekt\AppShell\Widgets;

use Konekt\AppShell\Contracts\Theme;
use Konekt\AppShell\Contracts\Widget;
use Konekt\AppShell\Theme\ThemeColor;
use Konekt\AppShell\Traits\ManipulatesColors;
use Konekt\AppShell\Traits\RendersThemedWidget;
use Konekt\AppShell\Widgets;

class Badge implements Widget
{
    use RendersThemedWidget;
    use ManipulatesColors;

    protected Text $text;

    protected static string $filterMethodName;

    public function __construct(Theme $theme, Text $text)
    {
        $this->theme = $theme;
        $this->text = $text;
    }

    public static function create(Theme $theme, array $options = []): Widget
    {
        return new static(
            $theme,
            Widgets::make(
                'text',
                self::calculateAttributes($options)
            )
        );
    }

    public function render($data = null): string
    {
        return $this->text->render($data);
    }

    private static function calculateAttributes(array $options): array
    {
        $result = $options;
        $result['wrap'] = $options['wrap'] ?? 'span';
        $style = null;
        $contextClass = 'badge-primary';

        $bgColor = $options['color'] ?? null;
        if (null !== $bgColor) {
            if (self::isThemeColor($bgColor)) {
                $contextClass = 'badge-' . $bgColor;
            } else {
                $contextClass = '';
                $style = "background-color: $bgColor;";
                if (self::needsWhiteText($bgColor)) {
                    $style .= 'color: #FFFFFF;';
                }
            }
        }

        $result['class'] = "badge badge-pill $contextClass " . ($options['class'] ?? '');

        if (null !== $style) {
            $result['style'] = $style;
        }

        return $result;
    }
}
