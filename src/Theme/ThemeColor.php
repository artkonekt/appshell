<?php

declare(strict_types=1);

/**
 * Contains the ThemeColor class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-03-22
 *
 */

namespace Konekt\AppShell\Theme;

use Konekt\Enum\Enum;

/**
 * @method static ThemeColor NONE ()
 * @method static ThemeColor PRIMARY ()
 * @method static ThemeColor SECONDARY ()
 * @method static ThemeColor INFO ()
 * @method static ThemeColor SUCCESS ()
 * @method static ThemeColor WARNING ()
 * @method static ThemeColor DANGER ()
 * @method static ThemeColor TEXT ()
 * @method static ThemeColor DARK ()
 * @method static ThemeColor LIGHT ()
 * @method static ThemeColor MUTED ()
 */
class ThemeColor extends Enum
{
    public const __DEFAULT = self::NONE;

    public const NONE = null;
    public const PRIMARY = 'primary';
    public const SECONDARY = 'secondary';
    public const INFO = 'info';
    public const SUCCESS = 'success';
    public const WARNING = 'warning';
    public const DANGER = 'danger';
    public const TEXT = 'text';
    public const DARK = 'dark';
    public const LIGHT = 'light';
    public const MUTED = 'muted';
}
