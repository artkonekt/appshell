<?php

use Illuminate\Support\Facades\Route;

if (app()->isLocal()) {
    Route::get('/theme', 'ThemeTestController@index')->name('theme.index');
    Route::get('/theme/{theme}/{page}', 'ThemeTestController@page')->name('theme.page');

    \Diglactic\Breadcrumbs\Breadcrumbs::for('appshell.dev.theme.index', function ($breadcrumbs) {
        $breadcrumbs->parent('home');
        $breadcrumbs->push('Themes', route('appshell.dev.theme.index'));
    });

    \Diglactic\Breadcrumbs\Breadcrumbs::for('appshell.dev.theme.page', function ($breadcrumbs, $theme, $page) {
        $breadcrumbs->parent('appshell.dev.theme.index');
        $breadcrumbs->push(ucfirst($theme));
        $breadcrumbs->push(ucfirst($page));
    });
}
