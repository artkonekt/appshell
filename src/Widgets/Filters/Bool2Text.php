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

namespace Konekt\AppShell\Widgets\Filters;

use Konekt\AppShell\Contracts\WidgetFilter;

class Bool2Text implements WidgetFilter
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

    public static function create(array $arguments): WidgetFilter
    {
        return new static($arguments[0] ?? 'true', $arguments[1] ?? 'false');
    }
}
