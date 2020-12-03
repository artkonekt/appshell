<?php

declare(strict_types=1);

/**
 * Contains the EmailDriver class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-12-03
 *
 */

namespace Konekt\AppShell\Models;

use Konekt\Enum\Enum;

class EmailDriver extends Enum
{
    public const __DEFAULT = self::SMTP;

    public const SMTP     = 'smtp';
    public const MAILGUN  = 'mailgun';
    public const SES      = 'ses';
    public const POSTMARK = 'postmark';

    public static array $labels = [];

    protected static function boot()
    {
        static::$labels = [
            self::SMTP     => __('SMTP'),
            self::MAILGUN  => __('Mailgun'),
            self::SES      => __('AWS SES'),
            self::POSTMARK => __('Postmark')
        ];
    }
}
