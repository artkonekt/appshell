<?php

namespace Konekt\AppShell\Models;

use Konekt\Enum\Enum;

class ChartResolution extends Enum
{
    public const __DEFAULT = self::DAILY;

    public const DAILY = 'daily';
    public const WEEKLY = 'weekly';
    public const MONTHLY = 'monthly';
    public const ANNUAL = 'annual';

    protected static array $labels = [];

    protected static function boot(): void
    {
        static::$labels = [
            self::DAILY => __('Daily'),
            self::WEEKLY => __('Weekly'),
            self::MONTHLY => __('Monthly'),
            self::ANNUAL => __('Annual'),
        ];
    }
}
