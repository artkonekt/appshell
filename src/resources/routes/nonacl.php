<?php

/*
|--------------------------------------------------------------------------
| AppShell's NON-ACL Web Routes
|
| Routes in this file will be added in a group attributes of which
| are to be defined in the box/module config file in the config
| key of routes.namespace, routes.prefix with smart defaults
|--------------------------------------------------------------------------
*/

Route::get('preferences', [
    'uses' => 'PreferencesController@index',
    'as'   => 'preferences.index'
]);
Route::put('preferences', [
    'uses' => 'PreferencesController@update',
    'as'   => 'preferences.update'
]);

Route::get('account', [
    'uses' => 'AccountController@display',
    'as'   => 'account.display'
]);
Route::put('account', [
    'uses' => 'AccountController@save',
    'as'   => 'account.save'
]);

Route::get('quicklinks', [
    'uses' => 'QuickLinkController@index',
    'as'   => 'quicklinks.index'
]);
Route::put('quicklinks', [
    'uses' => 'QuickLinkController@update',
    'as'   => 'quicklinks.update'
]);
