<?php

declare(strict_types=1);

/**
 * Contains the UnknownWidget class.
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
use Konekt\AppShell\Traits\RendersThemedWidget;

class UnknownWidget implements Widget
{
    use RendersThemedWidget;

    private array  $options;

    private string $widget;

    public function __construct(Theme $theme, string $widget, array $options = [])
    {
        $this->theme = $theme;
        $this->options = $options;
        $this->widget = $widget;
    }

    public static function create(Theme $theme, array $options = []): UnknownWidget
    {
        return new UnknownWidget($theme, $options['widget'], Arr::except($options, 'widget'));
    }

    public function render($data = null): string
    {
        return $this->renderViewFromTheme(
            $this->widget,
            array_merge(
                $this->options,
                ['data' => $data]
            )
        );
    }
}
