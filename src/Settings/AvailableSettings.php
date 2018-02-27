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

    public function __construct()
    {
        $this->items = new Collection();
    }

    /**
     * Register one or more setting with the system
     *
     * @param Setting|array $setting
     */
    public function register($setting)
    {

        if ($setting instanceof Setting) {
            $setting = [$setting];
        }

        foreach ($setting as $item) {
            if ( ! $item instanceof Setting) {
                throw new \InvalidArgumentException('Setting type can not be registered' . gettype($setting));
            }

            $this->items->put($item->key(), $item);
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
