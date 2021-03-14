<?php

declare(strict_types=1);

/**
 * Contains the WidgetServiceProvider class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-01-09
 *
 */

namespace Konekt\AppShell\Providers;

use Illuminate\Support\ServiceProvider;
use Konekt\AppShell\WidgetFilters;
use Konekt\AppShell\Widgets;

class WidgetServiceProvider extends ServiceProvider
{
    private array $builtInWidgets = [
        'text' => Widgets\Text::class,
        'link' => Widgets\Link::class,
        'badge' => Widgets\Badge::class,
        'badges' => Widgets\Badges::class,
        'show_date' => Widgets\ShowDate::class,
        'show_datetime' => Widgets\ShowDateTime::class,
        'show_time' => Widgets\ShowTime::class,
        'multi_text' => Widgets\MultiText::class,
        'table' => Widgets\Table::class,
        'table_actions' => Widgets\Table\Actions::class,
    ];

    private array $builtInFilters = [
        'uppercase' => Widgets\Filters\Uppercase::class,
        'lowercase' => Widgets\Filters\Lowercase::class,
        'bool2text' => Widgets\Filters\Bool2Text::class,
    ];

    public function register()
    {
        foreach ($this->builtInFilters as $id => $class) {
            WidgetFilters::add($id, $class);
        }

        foreach ($this->builtInWidgets as $id => $class) {
            Widgets::add($id, $class);
        }
    }
}
