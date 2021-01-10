<?php

declare(strict_types=1);

/**
 * Contains the MultiText class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-01-09
 *
 */

namespace Konekt\AppShell\Widgets;

use Konekt\AppShell\Contracts\Theme;
use Konekt\AppShell\Contracts\Widget;
use Konekt\AppShell\Traits\RendersThemedWidget;
use Konekt\AppShell\Traits\ResolvesSubstitutions;
use Konekt\AppShell\Widgets;

class MultiText implements Widget
{
    use RendersThemedWidget;
    use ResolvesSubstitutions;

    protected static array $primaryDefaults = ['text' => ['wrap' => 'span', 'class' => 'font-weight-bold']];

    protected static array $secondaryDefaults = ['text' => ['wrap' => 'div', 'class' => 'text-muted']];

    protected Widget $primary;

    protected Widget $secondary;

    public function __construct(Theme $theme, Widget $primary, Widget $secondary)
    {
        $this->theme = $theme;
        $this->primary = $primary;
        $this->secondary = $secondary;
    }
    public static function create(Theme $theme, array $options = []): MultiText
    {
        $primaryOptions = self::mergeWidgetOptions(self::$primaryDefaults, $options['primary'] ?? []);
        $primary = Widgets::make(isset($primaryOptions['url']) ? 'link' : 'text', $primaryOptions, $theme);

        $secondaryOptions = self::mergeWidgetOptions(self::$secondaryDefaults, $options['secondary'] ?? []);
        $secondary = Widgets::make(isset($secondaryOptions['url']) ? 'link' : 'text', $secondaryOptions, $theme);

        return new static($theme, $primary, $secondary);
    }

    public function render($data = null): string
    {
        return $this->renderViewFromTheme('multi_text', [
            'primary' => $this->primary,
            'secondary' => $this->secondary,
            'model' => $data,
        ]);
    }

    private static function mergeWidgetOptions(array $defaults, array $definition): array
    {
        if (isset($definition['url'])) {
            if (is_string($definition['text'])) {
                $definition['text'] = ['text' => $definition['text']];
            }

            return array_merge_recursive($defaults, $definition);
        }

        return array_merge($defaults['text'], $definition);
    }
}
