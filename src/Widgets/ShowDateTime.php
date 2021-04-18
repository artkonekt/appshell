<?php

declare(strict_types=1);

/**
 * Contains the ShowDateTime class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-01-10
 *
 */

namespace Konekt\AppShell\Widgets;

class ShowDateTime extends BaseDateTime
{
    protected static function filterMethodName(): string
    {
        return 'show_datetime';
    }
}
