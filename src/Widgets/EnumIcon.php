<?php

declare(strict_types=1);

/**
 * Contains the EnumIcon class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-04-18
 *
 */

namespace Konekt\AppShell\Widgets;

use Illuminate\Support\Arr;
use Konekt\AppShell\Contracts\Theme;
use Konekt\AppShell\Contracts\Widget;
use Konekt\AppShell\Traits\ResolvesSubstitutions;
use Konekt\AppShell\Widgets\Concerns\CalculatesContextualColors;

class EnumIcon implements Widget
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
        $value = $this->resolveSubstitutions($this->options['value'] ?? '$model', $data);
        $color = null;

        if (isset($this->options['color'])) {
            $def = $this->parseColorDefinition($this->options['color']);
            $color = $def->themeColor->isNone() ? null : $def->themeColor;
        }

        $attributes = Arr::except($this->options, ['value', 'color', 'type']);
        if (!isset($attributes['title'])) {
            $attributes['title'] = $value->label();
        }

        return icon(enum_icon($value), $color, $attributes);
    }
}
