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

    public readonly bool $is_hidden;

    public function __construct(string $id, array $attributes = [])
    {
        $this->id = $id;
        $this->title = $attributes['title'] ?? $id;

        $this->parseTableCellAttributes($attributes);
        $this->parseWidgetDefinition($attributes['widget'] ?? null);
        $this->is_hidden = match (isset($attributes['hideIf'])) {
            false => false,
            true => is_callable($attributes['hideIf']) ? call_user_func($attributes['hideIf']) : (bool) $attributes['hideIf'],
        };
    }

    public function isHidden(): bool
    {
        return $this->is_hidden;
    }

    public function render($lineData): string
    {
        if (null === $this->widget) {
            return (string) $this->getRawData($lineData, $this->id);
        }

        return Widgets::make($this->widget, $this->widgetOptions)->render($lineData);
    }
}
