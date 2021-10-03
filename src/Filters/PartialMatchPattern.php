<?php

declare(strict_types=1);

/**
 * Contains the PartialMatchPattern class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-09-18
 *
 */

namespace Konekt\AppShell\Filters;

use Konekt\Enum\Enum;

/**
 * @method static PartialMatchPattern BEGINS_WITH();
 * @method static PartialMatchPattern ENDS_WITH();
 * @method static PartialMatchPattern ANYWHERE();
 *
 * @method bool isBeginsWith()
 * @method bool isEndsWith()
 * @method bool isAnywhere()
 */
class PartialMatchPattern extends Enum
{
    public const __DEFAULT = self::BEGINS_WITH;
    public const BEGINS_WITH = 'begins';
    public const ENDS_WITH = 'ends';
    public const ANYWHERE = 'anywhere';

    public function sqlExpression(string $criteria): string
    {
        switch ($this->value) {
            case self::BEGINS_WITH:
                return "$criteria%";
            break;

            case self::ENDS_WITH:
                return "%$criteria";
            break;

            case self::ANYWHERE:
            default:
                return "%$criteria%";
            break;
        }
    }
}
