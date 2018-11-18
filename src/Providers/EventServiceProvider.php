<?php
/**
 * Contains the EventServiceProvider class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-05-19
 *
 */

namespace Konekt\AppShell\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Konekt\AppShell\Listeners\UpdateUserLoginData;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the AppShell
     *
     * @var array
     */
    protected $listen = [
        Login::class => [
            UpdateUserLoginData::class,
        ],
    ];
}
