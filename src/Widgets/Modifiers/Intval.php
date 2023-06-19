<?php

declare(strict_types=1);

/**
 * Contains the Intval class.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-06-19
 *
 */

namespace Konekt\AppShell\Widgets\Modifiers;

use Konekt\AppShell\Contracts\WidgetModifier;

class Intval implements WidgetModifier
{
    public function handle($value): string
    {
        return (string) intval($value);
    }

    public static function create(array $arguments): WidgetModifier
    {
        return new static();
    }
}
