<?php
/**
 * Contains the SettingsBackend interface.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-02-26
 *
 */


namespace Konekt\AppShell\Contracts;


use Illuminate\Support\Collection;
use Konekt\User\Contracts\User;

interface SettingsBackend
{
    /**
     * Returns all the saved settings
     *
     * @return Collection
     */
    public function all() : Collection;

    /**
     * Returns the value for a specific setting
     *
     * @param Setting       $setting
     * @param null|User|int $user
     *
     * @return mixed
     */
    public function get(Setting $setting, $user = null);

    /**
     * Sets the value for a specific setting
     *
     * @param Setting       $setting
     * @param mixed         $value
     * @param null|User|int $user
     *
     * @return mixed
     */
    public function set(Setting $setting, $value, $user = null);

}
