<?php

declare(strict_types=1);

/**
 * Contains the ShowDateTime class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-04-18
 *
 */

namespace Konekt\AppShell\Widgets\Filters;

use Konekt\AppShell\Contracts\WidgetFilter;

class ShowDateTime extends BaseDateTimeFilter implements WidgetFilter
{
    public function handle($value): string
    {
        return show_datetime($value, $this->unknownText);
    }
}
