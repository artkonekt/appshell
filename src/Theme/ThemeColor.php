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
    public const __DEFAULT = self::NONE;

    public const NONE      = null;
    public const PRIMARY   = 'primary';
    public const SECONDARY = 'secondary';
    public const INFO      = 'info';
    public const SUCCESS   = 'success';
    public const WARNING   = 'warning';
    public const DANGER    = 'danger';
    public const TEXT      = 'text';
    public const DARK      = 'dark';
    public const LIGHT     = 'light';
    public const MUTED     = 'muted';
}
