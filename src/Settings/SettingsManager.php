<?php
/**
 * Contains the SettingsManager class.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-02-26
 *
 */


namespace Konekt\AppShell\Settings;


use Illuminate\Support\Collection;
use Konekt\AppShell\Contracts\Setting;
use Konekt\AppShell\Contracts\SettingsBackend;
use Konekt\AppShell\Contracts\SettingScope;
use Konekt\AppShell\Contracts\SettingsGroup;
use Konekt\AppShell\Contracts\SettingsTab;
use Konekt\AppShell\Exceptions\SettingsTabNotFoundException;
use Konekt\AppShell\Models\SettingScopeProxy;
use Konekt\User\Contracts\User;

class SettingsManager
{
    /**@var Collection */
    protected $availableSettings;

    /** @var SettingsBackend */
    protected $backend;

    /** @var Collection */
    protected $tabs;

    public function __construct(SettingsBackend $backend)
    {
        $this->availableSettings = collect();
        $this->backend           = $backend;
        $this->tabs              = collect();
    }

    /**
     * Returns the value for a specific setting
     *
     * @param Setting|string $setting
     * @param null|User|int  $user
     *
     * @return mixed
     */
    public function get($setting, $user = null)
    {
        // @todo decide based on user if setting/preference
        $result = $this->backend->getSetting($setting);

        // Optimal case, we have a result from backend
        if (!is_null($result)) {
            return $result;
        }

        // Return default from the setting
        if ($setting instanceof Setting) {
            return $setting->default();
        }

        // We have received a setting key, so need to fetch the object
        $setting = $this->availableSettings->get($setting);

        return $setting ? $setting->default() : null;
    }

    public function set($setting, $value, $user = null)
    {
        $this->backend->setSetting($setting, $value);
    }

    public function save(array $settings)
    {
        foreach ($settings as $key => $value) {
            $this->set($key, $value);
        }
    }

    /**
     * Registers a settings tab
     *
     * @param SettingsTab $tab
     */
    public function registerTab(SettingsTab $tab)
    {
        $this->tabs->put($tab->id(), $tab);
    }

    /**
     * @return Collection
     */
    public function tabs()
    {
        return $this->tabs;
    }

    /**
     * Register a settings group
     *
     * @param SettingsGroup           $group
     * @param SettingsTab|string|null $tab The tab object or id to add the group to.
     *                                     If null, the group will be added to the
     *                                     very first tab
     *
     * @throws SettingsTabNotFoundException
     */
    public function registerGroup(SettingsGroup $group, $tab = null)
    {
        $tab = $this->findOrFirstTab($tab);

        if (!$tab) {
            throw new SettingsTabNotFoundException('Could not find a tab for the group');
        }

        $tab->groups()->put($group->id(), $group);
    }

    /**
     * Returns the collection of available setting objects
     *
     * @return Collection
     */
    public function available()
    {
        return $this->availableSettings;
    }

    /**
     * Register one or more setting(s) with the system
     *
     * @param Setting|string|array      $setting
     * @param SettingsGroup|string|null $group
     */
    public function registerSetting($setting, $group = null)
    {
        $registeredSettings = $this->register($setting);

        if ($group = $this->findOrFirstGroup($group)) {
            foreach ($registeredSettings as $setting) {
                $group->settings()->put($setting->key(), $setting);
            }
        }
    }

    /**
     * Returns the collection of available application-scoped settings
     *
     * @return Collection
     */
    public function forApplication()
    {
        return $this->availableSettings->byScope(SettingScopeProxy::APPLICATION());
    }

    /**
     * Returns the collection of available user-scoped settings
     *
     * @return Collection
     */
    public function forUser()
    {
        return $this->availableSettings->byScope(SettingScopeProxy::USER());
    }

    /**
     * Returns the available settings filtered by scope
     *
     * @param SettingScope $scope
     *
     * @return Collection
     */
    public function byScope(SettingScope $scope)
    {
        return $this->availableSettings->filter(function(Setting $item) use ($scope) {
            return $item->scope()->equals($scope);
        });
    }

    /**
     * Finds a tab based on object/string. If null given, the first tab is returned
     *
     * @param SettingsTab|string|null $tab
     *
     * @return SettingsTab|null
     */
    protected function findOrFirstTab($tab)
    {
        if (! $tab instanceof SettingsTab || ! is_string($tab) || ! is_null($tab)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Don't know how to get a settings tab from type `%s`",
                    is_object($tab) ? get_class($tab) : gettype($tab)
                )
            );
        }

        return $this->tabs->get(is_object($tab) ? $tab->id() : $tab, $this->tabs->first());
    }

    /**
     * Finds a group based on object/string. If null given, the first group is returned
     *
     * @param SettingsGroup|string|null $group
     *
     * @return SettingsGroup|null
     */
    protected function findOrFirstGroup($group)
    {
        if (! $group instanceof SettingsGroup || ! is_string($group) || ! is_null($group)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Don't know how to get a setting group from type `%s`",
                    is_object($group) ? get_class($group) : gettype($group)
                )
            );
        }

        $groupId = is_object($group) ? $group->id() : $group;
        foreach ($this->tabs as $tab) {
            if ($tab->groups()->has($groupId)) {
                return $tab->groups()->get($groupId);
            }
        }

        /** Fallback to first tab's first group */
        $firstTab = $this->tabs->first();
        if ($firstTab) {
            return $firstTab->groups()->first();
        }

        return null;
    }

    /**
     * Register one or more setting with the system
     *
     * @param Setting|string|array $setting
     *
     * @return Setting[] Returns the array of setting objects registered
     */
    protected function register($setting)
    {
        $settings = is_array($setting) ? $setting : [$setting];
        $result = [];

        foreach ($settings as $setting) {
            if (is_string($setting) && class_exists($setting)) {
                $setting = new $setting();
            }

            if ( ! $setting instanceof Setting) {
                throw new \InvalidArgumentException(
                    sprintf(
                        'Setting type (%s) can not be registered',
                        is_object($setting) ? get_class($setting) : gettype($setting)
                    )
                );
            }

            $this->availableSettings->put($setting->key(), $setting);
            $result[] = $setting;
        }

        return $result;
    }
}
