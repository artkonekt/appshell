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
use Konekt\AppShell\Widgets;

class WidgetServiceProvider extends ServiceProvider
{
    public function register()
    {
        foreach ($this->builtInWidgets as $id => $class) {
            Widgets::add($id, $class);
        }
    }

    private $builtInWidgets = [
        'text' => Widgets\Text::class,
        'link' => Widgets\Link::class,
        'badge' => Widgets\Badge::class,
        'show_date' => Widgets\ShowDate::class,
        'show_datetime' => Widgets\ShowDateTime::class,
        'show_time' => Widgets\ShowTime::class,
        'multi_text' => Widgets\MultiText::class,
        'table' => Widgets\Table::class,
    ];
}
