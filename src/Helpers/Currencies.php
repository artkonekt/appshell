<?php

declare(strict_types=1);

/**
 * Contains the Currencies class.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-07-10
 *
 */

namespace Konekt\AppShell\Helpers;

use Illuminate\Support\Arr;

class Currencies
{
    protected static ?array $db = null;

    public static function codes(): array
    {
        return array_keys(static::db());
    }

    public static function choices(): array
    {
        return static::db();
    }

    public static function nameOf(string $code): ?string
    {
        return static::db()[$code] ?? null;
    }

    public static function exists(string $code): bool
    {
        return array_key_exists($code, static::db());
    }

    public static function limitTo(string ...$codes): void
    {
        static::$db = Arr::only(static::readDatabase(), $codes);
    }

    public static function exclude(string ...$codes): void
    {
        if (null === static::$db) {
            static::revertToFullList();
        }

        Arr::forget(static::$db, $codes);
    }

    public static function revertToFullList(): void
    {
        static::$db = static::readDatabase();
    }

    public static function moveToTop(string ...$codes): void
    {
        $topOnes = [];
        foreach ($codes as $code) {
            $name = static::nameOf($code);
            if (null !== $name) {
                $topOnes[$code] = $name;
            }
        }

        static::exclude(...$codes);
        static::$db = $topOnes + static::$db;
    }

    protected static function db(): array
    {
        if (null === static::$db) {
            static::$db = static::readDatabase();
        }

        return static::$db;
    }

    protected static function readDatabase(): array
    {
        return json_decode(file_get_contents(dirname(__DIR__) . '/resources/database/currencies.json'), true);
    }
}
