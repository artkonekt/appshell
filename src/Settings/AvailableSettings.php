<?php
/**
 * Contains the AvailableSettings class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-02-25
 *
 */


namespace Konekt\AppShell\Settings;


use Illuminate\Support\Collection;
use Konekt\AppShell\Contracts\Setting;
use Konekt\AppShell\Contracts\SettingScope;

/**
 * Class that maintains the list of known (possible) settings for the application
 */
class AvailableSettings
{
    /** @var Collection */
    protected $items;

    /**
     * @param array $listOfSettings  An array of setting classes (string) or setting objects
     */
    public function __construct($listOfSettings = [])
    {
        $this->items = new Collection();

        $this->register($listOfSettings);
    }

    /**
     * Register one or more setting with the system
     *
     * @param Setting|string|array $setting
     */
    public function register($setting)
    {

        $settings = is_array($setting) ? $setting : [$setting];

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

            $this->items->put($setting->key(), $setting);
        }
    }

    /**
     * @return Collection
     */
    public function all()
    {
        return $this->items;
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
        return $this->items->filter(function(Setting $item) use ($scope) {
            return $item->scope()->equals($scope);
        });
    }

    /**
     * Returns one setting by it's key
     *
     * @param string $key
     *
     * @return Setting|null
     */
    public function getByKey($key)
    {
        return $this->items->get($key);
    }
}
