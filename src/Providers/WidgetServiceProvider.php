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
use Konekt\AppShell\WidgetModifiers;
use Konekt\AppShell\Widgets;
use Konekt\AppShell\Widgets\AppShellWidgetModifiers;
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

    private array $builtInModifiers = [
        AppShellWidgetModifiers::UPPERCASE => Widgets\Modifiers\Uppercase::class,
        AppShellWidgetModifiers::LOWERCASE => Widgets\Modifiers\Lowercase::class,
        AppShellWidgetModifiers::BOOL2TEXT => Widgets\Modifiers\Bool2Text::class,
        AppShellWidgetModifiers::SHOW_DATETIME => Widgets\Modifiers\ShowDateTime::class,
        AppShellWidgetModifiers::SHOW_DATE => Widgets\Modifiers\ShowDate::class,
        AppShellWidgetModifiers::SHOW_TIME => Widgets\Modifiers\ShowTime::class,
    ];

    public function register()
    {
        foreach ($this->builtInModifiers as $id => $class) {
            WidgetModifiers::add($id, $class);
        }

        foreach ($this->builtInWidgets as $id => $class) {
            Widgets::add($id, $class);
        }
    }
}
