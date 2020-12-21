<?php

/*
|--------------------------------------------------------------------------
| AppShell's Public Web Routes
|
| Routes in this file will be added to the `appshell.public.` group
| and are accessible publicly to anyone having the URL. This was
| intended for creating shareable URLs for unregistered folks
|--------------------------------------------------------------------------
*/

Route::get('invitation/{hash}', [
    'uses' => 'PublicInvitationController@show',
    'as'   => 'invitation.show'
])->where('hash', '[A-Za-z0-9]+');

Route::post('invitation/accept', [
    'uses' => 'PublicInvitationController@accept',
    'as'   => 'invitation.accept'
]);
