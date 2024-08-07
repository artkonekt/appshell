<?php

declare(strict_types=1);

/**
 * Contains the TridentTheme class.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-06-07
 *
 */

namespace Konekt\AppShell\Theme;

use Konekt\AppShell\Contracts\Theme;

class TridentTheme implements Theme
{
    use IsGenericTheme;

    public const ID = 'trident';

    private static string $name = 'Trident';

    private static string $viewNamespace = 'trident';

    private array $layouts = [
        'private' => 'trident::layouts.private',
        'public' => 'trident::layouts.public',
        'print' => 'trident::layouts.print',
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
}
