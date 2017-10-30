<?php
/**
 * Helper functions for AppShell
 *
 * @since       2017-10-02
 * @author      Attila Fulop
 * @license     MIT
 */


/**
 * Returns the icon for a specific enum (value)
 *
 * @param \Konekt\Enum\Enum $enum
 *
 * @return mixed
 */
function enum_icon(\Konekt\Enum\Enum $enum)
{
    return app('appshell.icon')->icon($enum);
}

/**
 * Returns whether the given array contains any of the keys
 *
 * @param array $haystack   The array to search for the keys
 * @param array $needles    The list of keys
 *
 * @return bool
 */
function any_key_exists(array $haystack, array $needles)
{
    return count(array_intersect(array_keys($haystack), $needles)) > 0;
}