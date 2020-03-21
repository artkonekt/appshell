<?php
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
use Konekt\AppShell\Exceptions\InexistentThemeException;

final class Themes
{
    /** @var array */
    private static $registry = [];

    public static function add(string $id, string $class)
    {
        if (array_key_exists($id, self::$registry)) {
            return;
        }

        if (!class_implements($class, Theme::class)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'The class you are trying to register (%s) as property type, ' .
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

        if (null === $themeClass) {
            throw new InexistentThemeException(
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
