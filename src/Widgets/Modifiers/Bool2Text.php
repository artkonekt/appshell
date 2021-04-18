<?php

declare(strict_types=1);

/**
 * Contains the Bool2Text class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-03-14
 *
 */

namespace Konekt\AppShell\Widgets\Modifiers;

use Konekt\AppShell\Contracts\WidgetModifier;

class Bool2Text implements WidgetModifier
{
    protected string $trueText;

    protected string $falseText;

    public function __construct(string $trueText, string $falseText)
    {
        $this->trueText = $trueText;
        $this->falseText = $falseText;
    }

    public function handle($value): string
    {
        return (bool) $value ? $this->trueText : $this->falseText;
    }

    public static function create(array $arguments): WidgetModifier
    {
        return new static($arguments[0] ?? 'true', $arguments[1] ?? 'false');
    }
}
