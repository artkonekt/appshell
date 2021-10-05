<?php

declare(strict_types=1);

/**
 * Contains the InvitationStatus class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-10-05
 *
 */

namespace Konekt\AppShell\Models;

use Konekt\AppShell\Theme\ThemeColor;
use Konekt\Enum\Enum;

/**
 * @method static InvitationStatus ACTIVE ()
 * @method static InvitationStatus EXPIRED ()
 * @method static InvitationStatus UTILIZED ()
 * @method static InvitationStatus INVALID ()
 *
 * @property-read ThemeColor $color
 */
class InvitationStatus extends Enum
{
    public const ACTIVE = 'active';
    public const EXPIRED = 'expired';
    public const UTILIZED = 'utilized';
    public const INVALID = 'invalid';

    protected static array $labels = [];

    public function color(): ThemeColor
    {
        switch ($this->value) {
            case self::ACTIVE:
                return ThemeColor::SUCCESS();
                break;
            case self::EXPIRED:
                return ThemeColor::WARNING();
                break;
            case self::UTILIZED:
                return ThemeColor::INFO();
                break;
            default:
                return ThemeColor::DANGER();
        }
    }

    public function __get($name)
    {
        if ('color' === $name) {
            return $this->color();
        }

        return parent::__get($name);
    }

    protected static function boot()
    {
        static::$labels = [
            self::ACTIVE => __('active'),
            self::EXPIRED => __('expired'),
            self::UTILIZED => __('utilized'),
            self::INVALID => __('invalid')
        ];
    }
}
