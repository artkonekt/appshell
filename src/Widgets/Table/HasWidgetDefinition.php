<?php

declare(strict_types=1);

/**
 * Contains the HasWidgetDefinition trait.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-10-08
 *
 */

namespace Konekt\AppShell\Widgets\Table;

use Illuminate\Support\Arr;

trait HasWidgetDefinition
{
    private ?string $widget;

    private array $widgetOptions = [];

    private function parseWidgetDefinition($widget): void
    {
        if (is_string($widget)) {
            $this->widget = $widget;
        } elseif (is_array($widget) && !empty($widget)) {
            $this->widget = $widget['type'] ?? null;
            $this->widgetOptions = Arr::except($widget, 'type');
        } else {
            $this->widget = null;
        }
    }
}
