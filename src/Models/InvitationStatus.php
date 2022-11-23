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

use Konekt\AppShell\Concerns\IsColoredEnum;
use Konekt\AppShell\Contracts\ThemeColored;
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
class InvitationStatus extends Enum implements ThemeColored
{
    use IsColoredEnum;

    public const ACTIVE = 'active';
    public const EXPIRED = 'expired';
    public const UTILIZED = 'utilized';
    public const INVALID = 'invalid';

    protected static array $labels = [];

    protected static $defaultColor = ThemeColor::DANGER;

    protected static $colors = [
        self::ACTIVE => ThemeColor::SUCCESS,
        self::EXPIRED => ThemeColor::WARNING,
        self::UTILIZED => ThemeColor::INFO,
    ];

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
