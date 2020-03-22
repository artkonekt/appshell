<?php
/**
 * Contains the SemanticColor class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-03-22
 *
 */

namespace Konekt\AppShell\Theme;

use Konekt\Enum\Enum;

class ThemeColor extends Enum
{
    const __default = self::PRIMARY;

    const PRIMARY   = 'primary';
    const SECONDARY = 'secondary';
    const INFO      = 'info';
    const SUCCESS   = 'success';
    const WARNING   = 'warning';
    const DANGER    = 'danger';
    const DARK      = 'dark';
    const LIGHT     = 'light';
}
