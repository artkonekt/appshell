<?php

/*
|--------------------------------------------------------------------------
| AppShell's Web Routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'appshell'], function() {
    Route::resource('user', 'UserController');
});

