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
    return app('appshell.theme')->semanticColorToHex($color);
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

    return sprintf("https://www.gravatar.com/avatar/%s.jpg?s=%d&d=%s",
        $hash, $size, $default
    );
}

function lumdiff($r1, $g1, $b1, $r2, $g2, $b2)
{
    $l1 = 0.2126 * pow($r1 / 255, 2.2) +
        0.7152 * pow($g1 / 255, 2.2) +
        0.0722 * pow($b1 / 255, 2.2);

    $l2 = 0.2126 * pow($r2 / 255, 2.2) +
        0.7152 * pow($g2 / 255, 2.2) +
        0.0722 * pow($b2 / 255, 2.2);

    if ($l1 > $l2) {
        return ($l1 + 0.05) / ($l2 + 0.05);
    }

    return ($l2 + 0.05) / ($l1 + 0.05);
}


