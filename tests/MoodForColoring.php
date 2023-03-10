<?php

declare(strict_types=1);

/**
 * Contains the MoodForColoring class.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-03-10
 *
 */

namespace Konekt\AppShell\Tests;

use Konekt\Enum\Enum;

class MoodForColoring extends Enum
{
    public const __DEFAULT = self::HAPPY;
    public const HAPPY = 'happy';
    public const IMOK = 'im_ok';
    public const MEH = 'meh';
    public const TIRED = 'tired';
    public const EXHAUSTED = 'exhausted';
}
