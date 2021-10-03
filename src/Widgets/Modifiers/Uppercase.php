<?php

declare(strict_types=1);

/**
 * Contains the Uppercase class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-03-14
 *
 */

namespace Konekt\AppShell\Widgets\Modifiers;

use Konekt\AppShell\Contracts\WidgetModifier;

class Uppercase implements WidgetModifier
{
    public function handle($value): string
    {
        return mb_strtoupper($value);
    }

    public static function create(array $arguments): WidgetModifier
    {
        return new static();
    }
}
