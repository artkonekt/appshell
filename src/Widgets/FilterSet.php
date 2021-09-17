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
use Konekt\AppShell\Contracts\Theme;
use Konekt\AppShell\Contracts\Widget;
use Konekt\AppShell\Traits\RendersThemedWidget;
use Konekt\AppShell\Widgets;

class FilterSet implements Widget
{
    use RendersThemedWidget;

    protected array $filters;

    protected string $route;

    public function __construct(Theme $theme, string $route, array $filters)
    {
        $this->theme = $theme;
        $this->filters = $filters;
        $this->route = $route;
    }

    public static function create(Theme $theme, array $options = []): Widget
    {
        $filters = [];
        foreach ($options['filters'] ?? [] as $id => $definition) {
            $filterOptions = [];
            if (is_numeric($id) && is_string($definition)) { // We have a bare list of columns ['id', 'name']
                $filterOptions['id'] = $definition;
            } else {
                $filterOptions = array_merge($definition, ['id' => $id]);
            }
            $filters[] = Widgets::make(AppShellWidgets::FILTER, $filterOptions, $theme);
        }

        return new static(
            $theme,
            $options['route'] ?? Route::currentRouteName(), // @todo make this work without named routes and current route
            $filters
        );
    }

    public function render($data = null): string
    {
        return $this->renderViewFromTheme('filterset', [
            'filters' => $this->filters,
            'route' => $this->route,
        ]);
    }
}
