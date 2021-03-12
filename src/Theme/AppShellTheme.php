<?php
/**
 * Contains the AppShellTheme class.
 *
 * @copyright   Copyright (c) 2019 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2019-02-24
 *
 */

namespace Konekt\AppShell\Theme;

use Konekt\AppShell\Contracts\Theme;

final class AppShellTheme implements Theme
{
    use IsGenericTheme;

    public const ID = 'appshell';

    private static string $name = 'AppShell';

    private static string $viewNamespace = 'appshell';

    private array $layouts = [
        'private' => 'appshell::layouts.default.private',
        'public'  => 'appshell::layouts.default.public',
        'print'   => 'appshell::layouts.default.print',
    ];

    private array $themeColors = [
        ThemeColor::PRIMARY   => '#385170',
        ThemeColor::SECONDARY => '#becdcf',
        ThemeColor::INFO      => '#0c9bd3',
        ThemeColor::SUCCESS   => '#23a38b',
        ThemeColor::WARNING   => '#e8c547',
        ThemeColor::DANGER    => '#f24236',
        ThemeColor::TEXT      => '#444444',
        ThemeColor::DARK      => '#607375',
        ThemeColor::LIGHT     => '#f1f3f3',
        ThemeColor::MUTED     => '#87a6ab',
        ThemeColor::NONE      => '#444444',
    ];
}
