<?php

declare(strict_types=1);

/**
 * Contains the TextIfEmpty class.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-06-16
 *
 */

namespace Konekt\AppShell\Widgets\Modifiers;

use Konekt\AppShell\Contracts\WidgetModifier;

class TextIfEmpty implements WidgetModifier
{
    public function __construct(
        protected string $fallbackText
    ) {
    }

    public function handle($value): string
    {
        return empty($value) ? $this->fallbackText : $value;
    }

    public static function create(array $arguments): WidgetModifier
    {
        return new static($arguments[0] ?? '-');
    }
}
