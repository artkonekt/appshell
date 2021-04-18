<?php

declare(strict_types=1);

/**
 * Contains the Filter class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-04-18
 *
 */

namespace Konekt\AppShell\Widgets;

use Konekt\AppShell\Contracts\Theme;
use Konekt\AppShell\Contracts\Widget;
use Konekt\AppShell\Traits\RendersThemedWidget;

class Filter implements Widget
{
    use RendersThemedWidget;

    protected string $id;

    public function __construct(Theme $theme, string $id)
    {
        $this->theme = $theme;
        $this->id = $id;
    }

    public static function create(Theme $theme, array $options = []): Widget
    {
        return new static($theme, $options['id']);
    }

    public function render($data = null): string
    {
        return $this->renderViewFromTheme('filter', ['id' => $this->id]);
    }
}
