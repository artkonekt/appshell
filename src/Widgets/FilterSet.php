<?php

declare(strict_types=1);

/**
 * Contains the FilterSet class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-04-18
 *
 */

namespace Konekt\AppShell\Widgets;

use Illuminate\Support\Facades\Route;
use Konekt\AppShell\Contracts\Filter as FilterContract;
use Konekt\AppShell\Contracts\Theme;
use Konekt\AppShell\Contracts\Widget;
use Konekt\AppShell\Filters\Filters;
use Konekt\AppShell\Traits\RendersThemedWidget;
use Konekt\AppShell\Widgets;

class FilterSet implements Widget
{
    use RendersThemedWidget;

    protected Filters $filters;

    protected array $widgets = [];

    protected string $route;

    public function __construct(Theme $theme, string $route, Filters $filters)
    {
        $this->theme = $theme;
        $this->filters = $filters;
        $this->route = $route;

        /** @var FilterContract $filter */
        foreach ($filters as $filter) {
            $options = [
                'id' => $filter->id(),
                'type' => $filter->widgetType(),
                'title' => $filter->label(),
                'placeholder' => $filter->placeholder(),
                'searchable' => $filter->searchable(),
                'options' => $filter->possibleValues(),
                'isActive' => $filters->isActive($filter->id()),
                'criteria' => $filters->activeOne($filter->id()) ? $filters->activeOne($filter->id())->criteria() : null,
            ];

            $this->widgets[] = Widgets::make(AppShellWidgets::FILTER, $options, $theme);
        }
    }

    public static function create(Theme $theme, array $options = []): Widget
    {
        return new static(
            $theme,
            $options['route'] ?? Route::currentRouteName(), // @todo make this work without named routes and current route
            $options['filters'] ?? Filters::make([])
        );
    }

    public function render($data = null): string
    {
        return $this->renderViewFromTheme('filterset', [
            'widgets' => $this->widgets,
            'filters' => $this->filters,
            'route' => $this->route,
        ]);
    }

    public function filters(): Filters
    {
        return $this->filters;
    }
}
