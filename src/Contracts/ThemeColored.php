<?php

declare(strict_types=1);

/**
 * Contains the Colored interface.
 *
 * @copyright   Copyright (c) 2022 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2022-11-23
 *
 */

namespace Konekt\AppShell\Contracts;

use Konekt\AppShell\Theme\ThemeColor;

interface ThemeColored
{
    public function color(): ThemeColor;
}
