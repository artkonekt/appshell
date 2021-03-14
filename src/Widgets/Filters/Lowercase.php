<?php

declare(strict_types=1);

/**
 * Contains the Lowercase class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-03-14
 *
 */

namespace Konekt\AppShell\Widgets\Filters;

use Konekt\AppShell\Contracts\WidgetFilter;

class Lowercase implements WidgetFilter
{
    public function handle($value): string
    {
        return mb_strtolower($value);
    }

    public static function create(array $arguments): WidgetFilter
    {
        return new static();
    }
}
