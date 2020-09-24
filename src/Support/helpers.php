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

function semantic_color_to_hex(string $color): string
{
    return app('appshell.theme')->themeColorToHex($color);
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

function avatar_image_url(\Konekt\User\Contracts\User $user = null, int $size = 100)
{
    if ($user) {
        $hash    = md5($user->email);
        $default = config('konekt.app_shell.avatar.gravatar.default');
    } else {
        $hash    = '00000000000000000000000000000000';
        $default = \Konekt\AppShell\Models\GravatarDefault::MYSTERY_PERSON;
    }

    return sprintf(
        "https://www.gravatar.com/avatar/%s.jpg?s=%d&d=%s",
        $hash,
        $size,
        $default
    );
}

if (!function_exists('show_date')) {
    /**
     * @param \Carbon\Carbon|\DateTimeInterface|string|null $date
     * @param string                                        $unknownDateText
     * @param string|null                                   $format
     *
     * @return string
     */
    function show_date($date, string $unknownDateText = '', string $format = null): string
    {
        return helper('date')->showDate($date, $unknownDateText, $format);
    }
}

if (!function_exists('show_datetime')) {
    /**
     * @param \Carbon\Carbon|\DateTimeInterface|string|null $datetime
     * @param string                                        $unknownDateTimeText
     * @param string|null                                   $format
     *
     * @return string
     */
    function show_datetime($datetime, string $unknownDateTimeText = '', string $format = null): string
    {
        return helper('date')->showDateTime($datetime, $unknownDateTimeText, $format);
    }
}

if (!function_exists('show_time')) {
    /**
     * @param \Carbon\Carbon|\DateTimeInterface|string|null $datetime
     * @param string                                        $unknownTimeText
     * @param string|null                                   $format
     *
     * @return string
     */
    function show_time($datetime, string $unknownTimeText = '', string $format = null): string
    {
        return helper('date')->showTime($datetime, $unknownTimeText, $format);
    }
}
