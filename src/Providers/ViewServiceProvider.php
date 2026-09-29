<?php

declare(strict_types=1);

/**
 * Contains the ViewServiceProvider class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-03-22
 *
 */

namespace Konekt\AppShell\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Konekt\AppShell\ViewComposers\ThemeComposer;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // @todo v5: we only want to inject it to all views if all the routes
        // in the app are running on appshell. If the app uses appshell an
        // area as a frontend without appshell, having injected is wrong
        View::composer('*', ThemeComposer::class);
    }
}
