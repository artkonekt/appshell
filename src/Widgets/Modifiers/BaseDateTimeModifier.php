<?php

declare(strict_types=1);

/**
 * Contains the BaseDateTimeModifier class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-04-18
 *
 */

namespace Konekt\AppShell\Widgets\Modifiers;

use Konekt\AppShell\Contracts\WidgetModifier;

abstract class BaseDateTimeModifier
{
    protected string $unknownText;

    public function __construct(string $unknownText)
    {
        $this->unknownText = $unknownText;
    }

    public static function create(array $arguments): WidgetModifier
    {
        return new static($arguments[0] ?? '-');
    }
}
