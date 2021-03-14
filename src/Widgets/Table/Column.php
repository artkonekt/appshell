<?php

declare(strict_types=1);

/**
 * Contains the Column class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-01-09
 *
 */

namespace Konekt\AppShell\Widgets\Table;

use Illuminate\Support\Arr;
use Konekt\AppShell\Traits\AccessesRawData;
use Konekt\AppShell\Widgets;

class Column
{
    use AccessesRawData;

    public string $title;

    public string $id;

    public ?string $width;

    private ?string $widget;

    private array $widgetOptions = [];

    public function __construct(string $id, array $attributes = [])
    {
        $this->id = $id;
        $this->title = $attributes['title'] ?? $id;
        $this->width = $attributes['width'] ?? null;

        $widget = $attributes['widget'] ?? null;
        if (is_string($widget)) {
            $this->widget = $widget;
        } elseif (is_array($widget)) {
            $this->widget = $widget['type'] ?? null;
            $this->widgetOptions = Arr::except($widget, 'type');
        } else {
            $this->widget = null;
        }
    }

    public function render($lineData): string
    {
        if (null === $this->widget) {
            return (string) $this->getRawData($lineData, $this->id);
        }

        return Widgets::make($this->widget, $this->widgetOptions)->render($lineData);
    }
}
