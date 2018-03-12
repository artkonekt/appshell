<?php
/**
 * Contains the BackendFactory class.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-03-12
 *
 */

namespace Konekt\AppShell\Settings;


use Konekt\AppShell\Contracts\SettingsBackend;

class BackendFactory
{
    /**
     * Creates a new backend instance based on the passed driver
     *
     * @param string $driver    Can be a short name for built in drivers eg. 'database' or a FQCN
     *
     * @return SettingsBackend
     */
    public static function create(string $driver) : SettingsBackend
    {
        if (strpos($driver, '\\') === false) {
            $class = __NAMESPACE__ . '\\Backends\\' . ucfirst($driver);
        } else {
            $class = $driver;
        }

        if (!class_exists($class)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Class `%s` does not exist, so it\'s far from being a good settings backend candidate',
                    $class
                )
            );
        }

        return app()->make($class);
    }

}