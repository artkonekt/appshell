<?php

declare(strict_types=1);

namespace Konekt\AppShell\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Konekt\AppShell\Theme\ThemeColor;
use Konekt\AppShell\Themes;
use Konekt\AppShell\ViewComposers\ThemeComposer;
use Konekt\Menu\Facades\Menu;

class ThemeTestController
{
    public function index()
    {
        $themes = [];
        foreach (Themes::ids() as $id) {
            $themes[$id] = Themes::make($id);
        }

        return view('appshell::theme-test.index', [
            'themes' => $themes,
            'colors' => ThemeColor::choices(),
        ]);
    }

    public function page($theme, $page)
    {
        Auth::onceUsingId(1);
        ThemeComposer::enforceTheme(Themes::make($theme));
        if ($appshellMenu = Menu::get('appshell')) {
            $names = $appshellMenu->items->map->name->toArray();
            foreach ($names as $name) {
                $appshellMenu->removeItem($name);
            }

            $appshellMenu->addItem('Widgets', 'widgets');
            foreach (['cards', 'buttons', 'alerts', 'forms', 'tables'] as $item) {
                $appshellMenu->addItem($item, ucfirst($item), ['url' => route('appshell.dev.theme.page', ['theme' => $theme, 'page' => $item])]);
            }
        }

        return view('appshell::theme-test.pages.' . $page);
    }
}
