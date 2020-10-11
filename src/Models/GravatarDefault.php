<?php
/**
 * Contains the GravatarDefault enum class.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-09-23
 *
 */

namespace Konekt\AppShell\Models;

use Konekt\AppShell\Contracts\GravatarDefault as GravatarDefaultContract;
use Konekt\Enum\Enum;

/**
 * @see https://en.gravatar.com/site/implement/images/#default-image
 */
class GravatarDefault extends Enum implements GravatarDefaultContract
{
    public const __DEFAULT = self::RETRO;

    public const HTTP404        = '404';
    public const MYSTERY_PERSON = 'mp';
    public const IDENTICON      = 'identicon';
    public const MONSTERID      = 'monsterid';
    public const WAVATAR        = 'wavatar';
    public const RETRO          = 'retro';
    public const ROBOHASH       = 'robohash';
    public const BLANK          = 'blank';
}
