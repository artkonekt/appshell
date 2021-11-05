<?php

declare(strict_types=1);

/**
 * Contains the FooterColumn class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-10-08
 *
 */

namespace Konekt\AppShell\Widgets\Table;

use Konekt\AppShell\Widgets;

class FooterColumn
{
    use HasWidgetDefinition;
    use HasTableCellAttributes;
    use AggregateFunctionAware;

    private ?string $text = null;

    /** @var null|callable */
    private $aggregateFunction = null;

    public function __construct(array $attributes = [])
    {
        $this->parseTextDefinition($attributes['text'] ?? null);
        $this->parseTableCellAttributes($attributes);

        $widget = $attributes['widget'] ?? null;
        if (null === $widget) {
            $this->widget = null;
        } else {
            $text = $this->aggregateFunction ?: $this->text;
            $this->parseWidgetDefinition(array_merge(['text' => $text], $attributes['widget']));
        }
    }

    public function render($data = null): string
    {
        if (null === $this->widget) {
            return $this->text($data);
        }

        return Widgets::make($this->widget, $this->widgetOptions)->render($data);
    }

    private function text($data = null): string
    {
        if (null === $this->aggregateFunction) {
            return (string) $this->text;
        }

        $aggregateFunction = $this->aggregateFunction;

        return (string) $aggregateFunction($data);
    }

    private function parseTextDefinition($definition): void
    {
        if (is_callable($definition)) {
            $this->aggregateFunction = $definition;

            return;
        }

        if (is_bool($definition)) {
            $this->text = '';

            return;
        }

        if (is_string($definition) && $this->isAggregateMethodDef($definition)) {
            $method = $this->getAggregateMethodName($definition);
            $params = $this->getAggregateMethodParams($definition);
            $this->aggregateFunction = fn ($model) => call_user_func([$model, $method], $params);

            return;
        }

        $this->text = (string) $definition;
    }
}
