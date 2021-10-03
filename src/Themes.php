<?php

declare(strict_types=1);

/**
 * Contains the Themes class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-03-21
 *
 */

namespace Konekt\AppShell;

use Konekt\AppShell\Contracts\Theme;
use Konekt\AppShell\Exceptions\NonExistentThemeException;

final class Themes
{
    private static array $registry = [];

    public static function add(string $id, string $class)
    {
        if (array_key_exists($id, self::$registry)) {
            return;
        }

        if (!in_array(Theme::class, class_implements($class))) {
            throw new \InvalidArgumentException(
                sprintf(
                    'The class you are trying to register (%s) as theme, ' .
                    'must implement the %s interface.',
                    $class,
                    Theme::class
                )
            );
        }

        self::$registry[$id] = $class;
    }

    public static function make(string $id): Theme
    {
        $themeClass = self::getClass($id);

        if (null === $themeClass && is_string($fallBackId = config('konekt.app_shell.ui.theme'))) {
            // Falling back to the default theme in the config
            $themeClass = self::getClass($fallBackId);
            if (function_exists('flash')) {
                flash()->warning(
                    __(
                        'There is no theme found with id :theme_id. Falling back to default. Check your application settings.',
                        ['theme_id' => $id]
                    )
                );
            }
        }

        if (null === $themeClass) {
            throw new NonExistentThemeException(
                "No theme is registered with the id `$id`."
            );
        }

        return app()->make($themeClass);
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
