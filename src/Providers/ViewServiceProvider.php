<?php
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
        View::composer('*', ThemeComposer::class);
    }
}
