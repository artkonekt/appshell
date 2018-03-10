<?php

/*
|--------------------------------------------------------------------------
| AppShell's Web Routes
|
| Routes in this file will be added in a group attributes of which
| are to be defined in the box/module config file in the config
| key of routes.namespace, routes.prefix with smart defaults
|--------------------------------------------------------------------------
*/

Route::resource('user', 'UserController');
Route::post('user/{$user}/activate', 'UserController@activate');
Route::post('user/{$user}/inactivate', 'UserController@inactivate');
Route::resource('role', 'RoleController');
Route::resource('customer', 'CustomerController');
Route::resource('address', 'AddressController');
Route::resource('setting', 'SettingsController');
