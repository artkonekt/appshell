<?php
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
    /** @var null|Theme */
    private $theme;

    public function compose($view)
    {
        $view->with('theme', $this->theme());
    }

//    public function getName(): string
//    {
//        $this->theme()->getName();
//    }
//
//    public function color(string $semanticColorName): string
//    {
//        return $this->theme()->semanticColorToHex($semanticColorName);
//    }
//
//    public function layout(string $variant): string
//    {
//        return $this->theme()->layout($variant);
//    }

    private function theme(): Theme
    {
        if (null === $this->theme) {
            $this->theme = app('appshell.theme');
        }

        return $this->theme;
    }
}
