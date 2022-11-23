<?php

declare(strict_types=1);

/**
 * Contains the ColorEnumIcon class.
 *
 * @copyright   Copyright (c) 2022 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2022-11-23
 *
 */

namespace Konekt\AppShell\Widgets;

use Illuminate\Support\Arr;
use Konekt\AppShell\Contracts\Theme;
use Konekt\AppShell\Contracts\Widget;
use Konekt\AppShell\Traits\ResolvesSubstitutions;

class ColorEnumIcon implements Widget
{
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
        $value = $this->resolveSubstitutions($this->options['value'] ?? '$model', $data);

        $this->detectAnimationIntent($data);

        $attributes = Arr::except($this->options, ['value', 'color', 'type']);
        if (!isset($attributes['title'])) {
            $attributes['title'] = $value->label();
        }

        return color_enum_icon($value, $attributes);
    }

    private function detectAnimationIntent($data): void
    {
        if (!isset($this->options['animate'])) {
            return;
        }

        if (isset($this->options['animateIf'])) {
            if (!$this->resolveSubstitutions($this->options['animateIf'], $data)) {
                unset($this->options['animate']);
                unset($this->options['animateIf']);
            }
        }
    }
}
