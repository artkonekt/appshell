<?php
/**
 * Contains the BaseBackend class.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-02-27
 *
 */


namespace Konekt\AppShell\Settings\Backends;


use Illuminate\Support\Collection;
use Konekt\AppShell\Contracts\Setting;
use Konekt\AppShell\Contracts\SettingsBackend;
use Konekt\User\Contracts\User;

abstract class BaseBackend implements SettingsBackend
{
    const USER_KEY_SEPARATOR = '@';

    /**
     * @inheritDoc
     */
    abstract public function allSettings(): Collection;

    /**
     * @inheritDoc
     */
    abstract public function allPreferences($user): Collection;

    /**
     * @inheritDoc
     */
    abstract public function getSetting($setting);

    /**
     * @inheritDoc
     */
    abstract public function getPreference($setting, $user);

    /**
     * @inheritDoc
     */
    abstract public function setSetting($setting, $value);

    /**
     * @inheritDoc
     */
    abstract public function setPreference($setting, $value, $user);

    /**
     * @param Setting|string $setting
     *
     * @return string
     */
    protected function getKey($setting)
    {
        return $setting instanceof Setting ? $setting->key() : (string) $setting;
    }

    /**
     * Returns the user id based on dynamic user parameter
     *
     * @param User|int|null $user
     *
     * @return int|null
     */
    protected function getUserId($user)
    {
        return $user instanceof User ? $user->id : $user;
    }
}
