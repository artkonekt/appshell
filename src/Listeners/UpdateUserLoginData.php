<?php
/**
 * Contains the UpdateUserLoginData.php class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-05-19
 *
 */


namespace Konekt\AppShell\Listeners;


use Carbon\Carbon;
use Illuminate\Auth\Events\Login;

class UpdateUserLoginData
{
    /**
     * Updates user's login data
     *
     * @param Login $event
     */
    public function handle(Login $event)
    {
        $event->user->last_login_at = Carbon::now();
        $event->user->login_count += 1;
        $event->user->save();
    }

}