<?php

declare(strict_types=1);

/**
 * Contains the BaseDateTimeFilter class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-04-18
 *
 */

namespace Konekt\AppShell\Widgets\Filters;

use Konekt\AppShell\Contracts\WidgetFilter;

abstract class BaseDateTimeFilter
{
    protected string $unknownText;

    public function __construct(string $unknownText)
    {
        $this->unknownText = $unknownText;
    }

    public static function create(array $arguments): WidgetFilter
    {
        return new static($arguments[0] ?? '-');
    }
}
