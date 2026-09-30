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

use Illuminate\Support\Facades\View;
use Konekt\AppShell\Contracts\Theme;

class TridentTheme implements Theme
{
    use IsGenericTheme;

    public const ID = 'trident';

    private static string $name = 'Trident';

    private static string $viewNamespace = 'trident';

    private static bool $viewNamespaceRegistered = false;

    private array $layouts = [
        'private' => 'trident::layouts.private',
        'public' => 'trident::layouts.public',
        'print' => 'trident::layouts.print',
    ];

    private array $themeColors = [
        ThemeColor::PRIMARY => '#146EBE',
        ThemeColor::SECONDARY => '#E8E8E4',
        ThemeColor::INFO => '#75A0D2',
        ThemeColor::SUCCESS => '#9593C4',
        ThemeColor::WARNING => '#FFB072',
        ThemeColor::DANGER => '#CF5F89',
        ThemeColor::TEXT => '#0D1D32',
        ThemeColor::DARK => '#0D1D32',
        ThemeColor::LIGHT => '#F2EFFE',
        ThemeColor::MUTED => '#F2EFFE',
        ThemeColor::NONE => '#444444',
    ];

    public function __construct()
    {
        if (!self::$viewNamespaceRegistered) {
            View::addNamespace(self::$viewNamespace, dirname(__DIR__) . '/resources/themes/trident/views');
        }
    }
}
