<?php
/**
 * Contains the DefaultAppShellTheme class.
 *
 * @copyright   Copyright (c) 2019 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2019-02-24
 *
 */

namespace Konekt\AppShell\Theme;

use Konekt\AppShell\Contracts\Theme;

final class DefaultAppShellTheme implements Theme
{
    use IsGenericTheme;

    public const ID = 'appshell.default';

    private static $name = 'AppShell Default';

    private static $viewNamespace = 'appshell';

    private $layouts = [
        'private' => 'appshell::layouts.default.private',
        'public'  => 'appshell::layouts.default.public',
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
