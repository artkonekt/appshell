<?php

declare(strict_types=1);

/**
 * Contains the AppShellWidgetModifiers class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-04-18
 *
 */

namespace Konekt\AppShell\Widgets;

final class AppShellWidgetModifiers
{
    public const BOOL2TEXT = 'bool2text';

    public const TEXT_IF_EMPTY = 'text_if_empty';
    public const LOWERCASE = 'lowercase';
    public const UPPERCASE = 'uppercase';
    public const SHOW_DATETIME = 'show_datetime';
    public const SHOW_DATE = 'show_date';
    public const SHOW_TIME = 'show_time';
}
