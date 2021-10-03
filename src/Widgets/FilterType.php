<?php

declare(strict_types=1);

/**
 * Contains the FilterType class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-09-17
 *
 */

namespace Konekt\AppShell\Widgets;

use Konekt\Enum\Enum;

class FilterType extends Enum
{
    public const __DEFAULT = self::TEXT;

    public const SELECT = 'select';
    public const MULTISELECT = 'multiselect';
    public const CHECKBOX = 'checkbox';
    public const SWITCH = 'switch';
    public const TEXT = 'text';
}
