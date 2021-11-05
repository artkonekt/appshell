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

use Illuminate\Support\Arr;
use Konekt\AppShell\Contracts\Theme;
use Konekt\AppShell\Contracts\Widget;
use Konekt\AppShell\Theme\ThemeColor;
use Konekt\AppShell\Traits\RendersThemedWidget;
use Konekt\AppShell\Traits\ResolvesSubstitutions;
use Konekt\AppShell\Widgets;

class MultiText implements Widget
{
    use RendersThemedWidget;
    use ResolvesSubstitutions;

    protected static array $primaryDefaults = ['text' => ['wrap' => 'span', 'bold' => true]];

    protected static array $secondaryDefaults = ['text' => ['wrap' => 'div', 'class' => 'text-muted']];

    protected static array $extraDefaults = ['text' => ['wrap' => 'span', 'class' => 'text-muted']];

    protected Widget $primary;

    protected Widget $secondary;

    protected array $extras = [];

    public function __construct(Theme $theme, Widget $primary, Widget $secondary)
    {
        $this->theme = $theme;
        $this->primary = $primary;
        $this->secondary = $secondary;
    }
    public static function create(Theme $theme, array $options = []): MultiText
    {
        $primaryOptions = self::mergeWidgetOptions(self::$primaryDefaults, $options['primary'] ?? []);
        $priType = $primaryOptions['type'] ?? (isset($primaryOptions['url']) ? 'link' : 'text');
        $primary = Widgets::make($priType, $primaryOptions, $theme);

        $secondaryOptions = self::mergeWidgetOptions(self::$secondaryDefaults, $options['secondary'] ?? []);
        $secType = $secondaryOptions['type'] ?? (isset($secondaryOptions['url']) ? 'link' : 'text');
        $secondary = Widgets::make($secType, $secondaryOptions, $theme);

        $instance = new static($theme, $primary, $secondary);

        foreach ($options['primary']['extras'] ?? [] as $extra) {
            if (isset($extra['text'])) {
                $instance->addExtraWidget(
                    Text::create($theme, self::mergeWidgetOptions(self::$extraDefaults, $extra))
                );
            } elseif (isset($extra['icon'])) {
                $instance->addExtraWidget(
                    RawHtml::create($theme, array_merge(
                        Arr::except($extra, ['html', 'icon']),
                        ['html' => icon($extra['icon'], ThemeColor::MUTED)]
                    ))
                );
            } elseif (isset($extra['html'])) {
                $instance->addExtraWidget(RawHtml::create($theme, $extra));
            } elseif (isset($extra['badge'])) {
                $instance->addExtraWidget(
                    Badge::create($theme, array_merge(
                        Arr::except($extra, ['badge']),
                        ['text' => $extra['badge']]
                    ))
                );
            }
        }

        return $instance;
    }

    public function render($data = null): string
    {
        return $this->renderViewFromTheme('multi_text', [
            'primary' => $this->primary,
            'extras' => $this->extras,
            'secondary' => $this->secondary,
            'model' => $data,
        ]);
    }

    private function addExtraWidget(Widget $extra): void
    {
        $this->extras[] = $extra;
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
