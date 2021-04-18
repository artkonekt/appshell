<?php

declare(strict_types=1);

/**
 * Contains the ShowDate class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-01-09
 *
 */

namespace Konekt\AppShell\Widgets;

class ShowDate extends BaseDateTime
{
    protected static function modifierMethodName(): string
    {
        return 'show_date';
    }
}
