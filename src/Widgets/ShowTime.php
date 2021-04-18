<?php

declare(strict_types=1);

/**
 * Contains the ShowTime class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-01-10
 *
 */

namespace Konekt\AppShell\Widgets;

class ShowTime extends BaseDateTime
{
    protected static function filterMethodName(): string
    {
        return 'show_time';
    }
}
