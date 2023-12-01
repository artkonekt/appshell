<?php

declare(strict_types=1);

/**
 * Contains the WidgetModifiers class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-03-14
 *
 */

namespace Konekt\AppShell;

use Konekt\AppShell\Contracts\WidgetModifier;
use Konekt\AppShell\Exceptions\UnknownWidgetModifierException;
use Konekt\Extend\Concerns\HasRegistry;
use Konekt\Extend\Concerns\RequiresClassOrInterface;

final class WidgetModifiers
{
    use HasRegistry;
    use RequiresClassOrInterface;

    protected static string $requiredInterface = WidgetModifier::class;

    public static function make(string $definition): WidgetModifier
    {
        $parsedDef = self::parse($definition);
        $id = (string) $parsedDef['id'];
        $class = self::getClassOf($id);

        if (null === $class) {
            throw new UnknownWidgetModifierException("Couldn't recognize modifier from `$id`");
        }

        return $class::create($parsedDef['args']);
    }

    public static function exists(string $definition): bool
    {
        return null !== self::getClassOf(self::parse($definition)['id'] ?? '');
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
