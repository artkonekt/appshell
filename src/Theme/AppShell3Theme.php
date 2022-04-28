<?php

declare(strict_types=1);

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

final class AppShell3Theme implements Theme
{
    use IsGenericTheme;

    public const ID = 'appshell';

    private static string $name = 'AppShell 3';

    private static string $viewNamespace = 'appshell';

    private array $layouts = [
        'private' => 'appshell::layouts.appshell3.private',
        'public' => 'appshell::layouts.appshell3.public',
        'print' => 'appshell::layouts.appshell3.print',
    ];

    private array $themeColors = [
        ThemeColor::PRIMARY => '#146ebe',
        ThemeColor::SECONDARY => '#f1f1f1',
        ThemeColor::INFO => '#75a0d2',
        ThemeColor::SUCCESS => '#9593C4',
        ThemeColor::WARNING => '#f9df79',
        ThemeColor::DANGER => '#cf5f89',
        ThemeColor::TEXT => '#0d1d32',
        ThemeColor::DARK => '#607375',
        ThemeColor::LIGHT => '#f1f3f3',
        ThemeColor::MUTED => '#737376',
        ThemeColor::NONE => '#444444',
    ];

    public function componentNamespace(): string
    {
        return '\\Konekt\\AppShell\\Components';
    }
}
