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
    const __default = self::RETRO;

    const HTTP404        = '404';
    const MYSTERY_PERSON = 'mp';
    const IDENTICON      = 'identicon';
    const MONSTERID      = 'monsterid';
    const WAVATAR        = 'wavatar';
    const RETRO          = 'retro';
    const ROBOHASH       = 'robohash';
    const BLANK          = 'blank';
}
