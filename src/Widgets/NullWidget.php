<?php

declare(strict_types=1);

/**
 * Contains the NullWidget class.
 *
 * @copyright   Copyright (c) 2022 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2022-11-23
 *
 */

namespace Konekt\AppShell\Widgets;

use Konekt\AppShell\Contracts\Theme;
use Konekt\AppShell\Contracts\Widget;

class NullWidget implements Widget
{
    public static function create(Theme $theme, array $options = []): Widget
    {
        return new self();
    }

    public function render($data = null): string
    {
        return '';
    }
}
