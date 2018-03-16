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
    public function allSettings() : Collection;

    /**
     * Returns all the saved preferences for a user
     *
     * @param User|int  $user
     *
     * @return Collection
     */
    public function allPreferences($user) : Collection;

    /**
     * Returns the value for a specific setting
     *
     * @param Setting|string $setting
     *
     * @return mixed
     */
    public function getSetting($setting);

    /**
     * Returns the value of a specific preference for a user
     *
     * @param Setting|string $setting
     * @param User|int       $user
     *
     * @return mixed
     */
    public function getPreference($setting, $user);

    /**
     * Sets the value for a specific setting
     *
     * @param Setting|string $setting
     * @param mixed          $value
     *
     * @return mixed
     */
    public function setSetting($setting, $value);

    /**
     * Sets the value for a specific setting
     *
     * @param Setting|string $setting
     * @param mixed          $value
     * @param User|int       $user
     *
     * @return mixed
     */
    public function setPreference($setting, $value, $user);
}
