<?php

declare(strict_types=1);

/**
 * Contains the IconThemes class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-10-18
 *
 */

namespace Konekt\AppShell;

use Konekt\AppShell\Contracts\IconTheme;
use Konekt\AppShell\Exceptions\NonExistentIconThemeException;

final class IconThemes
{
    /** @var array */
    private static array $registry = [];

    public static function add(string $id, string $class)
    {
        if (array_key_exists($id, self::$registry)) {
            return;
        }

        if (!in_array(IconTheme::class, class_implements($class))) {
            throw new \InvalidArgumentException(
                sprintf(
                    'The class you are trying to register (%s) as icon theme, ' .
                    'must implement the %s interface.',
                    $class,
                    IconTheme::class
                )
            );
        }

        self::$registry[$id] = $class;
    }

    public static function make(string $id): IconTheme
    {
        $iconThemeClass = self::getClass($id);

        if (null === $iconThemeClass && is_string($fallBackId = config('konekt.app_shell.ui.icon_theme'))) {
            // Falling back to the default icon theme in the config
            $iconThemeClass = self::getClass($fallBackId);
            if (function_exists('flash')) {
                flash()->warning(
                    __(
                        'There is no icon theme found with id :icon_theme_id. Falling back to default. Check your application settings.',
                        ['icon_theme_id' => $id]
                    )
                );
            }
        }

        if (null === $iconThemeClass) {
            throw new NonExistentIconThemeException(
                "No icon theme is registered with the id `$id`."
            );
        }

        return app()->make($iconThemeClass);
    }

    public static function reset(): void
    {
        self::$registry = [];
    }

    public static function getClass(string $id): ?string
    {
        return self::$registry[$id] ?? null;
    }

    public static function ids(): array
    {
        return array_keys(self::$registry);
    }

    public static function choices(): array
    {
        $result = [];

        foreach (self::$registry as $type => $class) {
            $result[$type] = $class::getName();
        }

        return $result;
    }
}
