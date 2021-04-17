<?php

/*
|--------------------------------------------------------------------------
| AppShell's Web Routes Governed by ACL
|
| Routes in this file will be added in a group attributes of which
| are to be defined in the box/module config file in the config
| key of routes.namespace, routes.prefix with smart defaults
|--------------------------------------------------------------------------
*/

Route::prefix('user')->group(function () {
    Route::resource('invitation', 'InvitationController');
});

Route::resource('user', 'UserController');
Route::post('user/{user}/activate', [
    'uses' => 'UserController@activate',
    'as'   => 'user.activate'
]);
Route::post('user/{user}/inactivate', [
    'uses' => 'UserController@inactivate',
    'as'   => 'user.inactivate'
]);

Route::resource('role', 'RoleController');
Route::resource('customer', 'CustomerController');
Route::resource('address', 'AddressController');

Route::get('settings', [
    'uses' => 'SettingsController@index',
    'as'   => 'settings.index'
]);
Route::put('settings', [
    'uses' => 'SettingsController@update',
    'as'   => 'settings.update'
]);
