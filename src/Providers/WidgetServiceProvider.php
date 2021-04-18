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
use Konekt\AppShell\Widgets\AppShellFilters;
use Konekt\AppShell\Widgets\AppShellWidgets;

class WidgetServiceProvider extends ServiceProvider
{
    private array $builtInWidgets = [
        AppShellWidgets::TEXT => Widgets\Text::class,
        AppShellWidgets::LINK => Widgets\Link::class,
        AppShellWidgets::BADGE => Widgets\Badge::class,
        AppShellWidgets::BADGES => Widgets\Badges::class,
        AppShellWidgets::ENUM_ICON => Widgets\EnumIcon::class,
        AppShellWidgets::SHOW_DATE => Widgets\ShowDate::class,
        AppShellWidgets::SHOW_DATETIME => Widgets\ShowDateTime::class,
        AppShellWidgets::SHOW_TIME => Widgets\ShowTime::class,
        AppShellWidgets::MULTI_TEXT => Widgets\MultiText::class,
        AppShellWidgets::TABLE => Widgets\Table::class,
        AppShellWidgets::TABLE_ACTIONS => Widgets\Table\Actions::class,
    ];

    private array $builtInFilters = [
        AppShellFilters::UPPERCASE => Widgets\Filters\Uppercase::class,
        AppShellFilters::LOWERCASE => Widgets\Filters\Lowercase::class,
        AppShellFilters::BOOL2TEXT => Widgets\Filters\Bool2Text::class,
        AppShellFilters::SHOW_DATETIME => Widgets\Filters\ShowDateTime::class,
        AppShellFilters::SHOW_DATE => Widgets\Filters\ShowDate::class,
        AppShellFilters::SHOW_TIME => Widgets\Filters\ShowTime::class,
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
