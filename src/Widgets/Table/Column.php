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

use Konekt\AppShell\Traits\AccessesRawData;
use Konekt\AppShell\Widgets;

class Column
{
    use AccessesRawData;
    use HasWidgetDefinition;
    use HasTableCellAttributes;

    public string $title;

    public string $id;

    public function __construct(string $id, array $attributes = [])
    {
        $this->id = $id;
        $this->title = $attributes['title'] ?? $id;

        $this->parseTableCellAttributes($attributes);
        $this->parseWidgetDefinition($attributes['widget'] ?? null);
    }

    public function render($lineData): string
    {
        if (null === $this->widget) {
            return (string) $this->getRawData($lineData, $this->id);
        }

        return Widgets::make($this->widget, $this->widgetOptions)->render($lineData);
    }
}
