<?php

declare(strict_types=1);

/**
 * Contains the WidgetFilters class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-03-14
 *
 */

namespace Konekt\AppShell;

use Konekt\AppShell\Contracts\WidgetFilter;
use Konekt\AppShell\Exceptions\UnknownWidgetFilterException;

final class WidgetFilters
{
    private static array $registry = [];

    public static function add(string $id, string $class): bool
    {
        if (array_key_exists($id, self::$registry)) {
            return false;
        }

        self::override($id, $class);

        return true;
    }

    public static function override(string $id, string $class): void
    {
        if (!in_array(WidgetFilter::class, class_implements($class))) {
            throw new \InvalidArgumentException(
                sprintf(
                    'The class you are trying to register (%s) as a widget filter, ' .
                    'must implement the %s interface.',
                    $class,
                    WidgetFilter::class
                )
            );
        }

        self::$registry[$id] = $class;
    }

    public static function make(string $definition): WidgetFilter
    {
        $parsedDef = self::parse($definition);
        $id = (string) $parsedDef['id'];
        $class = self::getClass($id);

        if (null === $class) {
            throw new UnknownWidgetFilterException("Couldn't recognize filter from `$id`");
        }

        return $class::create($parsedDef['args']);
    }

    public static function exists(string $definition): bool
    {
        return null !== self::getClass(self::parse($definition)['id'] ?? '');
    }

    public static function getClass(string $id): ?string
    {
        return self::$registry[$id] ?? null;
    }

    /**
     * @return array
     *  {
     *      id: string,
     *      args: array
     *  }
     */
    private static function parse(string $definition): array
    {
        $result = ['args' => []];
        $tokens = explode(':', $definition);
        $result['id'] = trim($tokens[0]);

        if (isset($tokens[1])) {
            foreach (explode(',', $tokens[1]) as $arg) {
                $result['args'][] = trim($arg);
            };
        }

        return $result;
    }
}
