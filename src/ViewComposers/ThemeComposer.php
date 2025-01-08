<?php

declare(strict_types=1);

/**
 * Contains the ThemeComposer class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-03-22
 *
 */

namespace Konekt\AppShell\ViewComposers;

use Konekt\AppShell\Contracts\Theme;

class ThemeComposer
{
    private ?Theme $theme = null;

    private static ?Theme $forcedTheme = null;

    public function compose($view)
    {
        $view->with('theme', $this->theme());
    }

    public static function enforceTheme(Theme $theme)
    {
        self::$forcedTheme = $theme;
    }

    private function theme(): Theme
    {
        if (null === $this->theme) {
            $this->theme = self::$forcedTheme ?? app('appshell.theme');
        }

        return $this->theme;
    }
}
