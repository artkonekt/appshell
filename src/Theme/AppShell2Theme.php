<?php
/**
 * Contains the AppShell2Theme class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-03-21
 *
 */

namespace Konekt\AppShell\Theme;

use Konekt\AppShell\Contracts\Theme;

final class AppShell2Theme implements Theme
{
    use IsGenericTheme;

    public const ID = 'appshell.2';

    private static $name = 'AppShell 2';

    private $layouts = [
        'private' => 'appshell::layouts.v2.private',
        'public'  => 'appshell::layouts.v2.public',
    ];

    private $themeColors = [
        'primary'   => '#385170',
        'secondary' => '#becdcf',
        'info'      => '#0c9bd3',
        'success'   => '#23a38b',
        'warning'   => '#e8c547',
        'danger'    => '#f24236',
        'text'      => '#444',
        'dark'      => '#607375',
        'light'     => '#f1f3f3',
    ];
}
