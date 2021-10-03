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

namespace Konekt\AppShell\Widgets\Modifiers;

use Konekt\AppShell\Contracts\WidgetModifier;

class ShowDate extends BaseDateTimeModifier implements WidgetModifier
{
    public function handle($value): string
    {
        return show_date($value, $this->unknownText);
    }
}
