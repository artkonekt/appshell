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

final class AppShellTheme implements Theme
{
    use IsGenericTheme;

    public const ID = 'appshell';

    private static string $name = 'AppShell';

    private static string $viewNamespace = 'appshell';

    private array $layouts = [
        'private' => 'appshell::layouts.default.private',
        'public' => 'appshell::layouts.default.public',
        'print' => 'appshell::layouts.default.print',
    ];

    private array $themeColors = [
        ThemeColor::PRIMARY => '#385170',
        ThemeColor::SECONDARY => '#8EA1A4',
        ThemeColor::INFO => '#4A9DBE',
        ThemeColor::SUCCESS => '#29C79C',
        ThemeColor::WARNING => '#E8CC67',
        ThemeColor::DANGER => '#F2504A',
        ThemeColor::TEXT => '#303335',
        ThemeColor::DARK => '#607375',
        ThemeColor::LIGHT => '#F1F3F3',
        ThemeColor::MUTED => '#8EA1A4',
        ThemeColor::NONE => '#444444',
    ];
}
