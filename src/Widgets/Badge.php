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
use Konekt\AppShell\Traits\ResolvesSubstitutions;
use Konekt\AppShell\Widgets;
use Konekt\AppShell\Widgets\Concerns\CalculatesContextualColors;

class Badge implements Widget
{
    use CalculatesContextualColors;
    use ResolvesSubstitutions;

    protected Theme $theme;

    protected array $options;

    public function __construct(Theme $theme, array $options)
    {
        $this->theme = $theme;
        $this->options = $options;
    }

    public static function create(Theme $theme, array $options = []): Widget
    {
        return new static($theme, $options);
    }

    public function render($data = null): string
    {
        return Widgets::make('text', $this->calculateAttributes($this->options, $data), $this->theme)
            ->render($data);
    }

    private function calculateAttributes(array $options, $data = null): array
    {
        $result = $options;
        $result['wrap'] = $options['wrap'] ?? 'span';

        $value = $this->resolveSubstitutions($options['text'] ?? '$model', $data);
        $colorDef = $options['color'] ?? null;
        $bgColor = $this->parseColorDefinition(
            is_string($colorDef) ? $this->resolveSubstitutions($colorDef, $data) : $colorDef,
            $value
        );
        $contextClass = $bgColor->themeColor->isNone() ? '' : 'bg-' . $bgColor->themeColor->value();
        $result['class'] = "badge rounded-pill $contextClass " . ($options['class'] ?? '');

        if (null !== $bgColor->style) {
            $result['style'] = $bgColor->style;
        }

        return $result;
    }
}
