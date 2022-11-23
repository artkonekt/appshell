<?php

declare(strict_types=1);

/**
 * Contains the ColorAttributes class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-03-14
 *
 */

namespace Konekt\AppShell\Widgets\Dto;

use Konekt\AppShell\Theme\ThemeColor;

final class ColorAttributes
{
    public ThemeColor $themeColor;

    public ?string $style;

    public function __construct(ThemeColor $themeColor, ?string $style)
    {
        $this->themeColor = $themeColor;
        $this->style = $style;
    }

    public function isEmpty(): bool
    {
        return null === $this->style && $this->themeColor->isNone();
    }

    public function isNotEmpty(): bool
    {
        return !$this->isEmpty();
    }
}
