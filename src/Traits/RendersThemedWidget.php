<?php

declare(strict_types=1);

/**
 * Contains the RendersThemedWidget trait.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-01-09
 *
 */

namespace Konekt\AppShell\Traits;

use Illuminate\Support\Facades\View;
use Konekt\AppShell\Contracts\Theme;

trait RendersThemedWidget
{
    private Theme $theme;

    private function renderViewFromTheme(string $widget, array $data = []): string
    {
        return View::make(
            $this->theme->viewNamespace() . "::widgets.$widget",
            $data
        )->render();
    }
}
