<?php

declare(strict_types=1);

/**
 * Contains the Widget interface.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-01-09
 *
 */

namespace Konekt\AppShell\Contracts;

interface Widget
{
    public static function create(Theme $theme, array $options = []): Widget;

    public function render($data = null): string;
}
