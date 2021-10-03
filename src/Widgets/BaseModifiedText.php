<?php

declare(strict_types=1);

/**
 * Contains the BaseModifiedText class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-01-10
 *
 */

namespace Konekt\AppShell\Widgets;

use Konekt\AppShell\Contracts\Theme;
use Konekt\AppShell\Contracts\Widget;
use Konekt\AppShell\Traits\RendersThemedWidget;
use Konekt\AppShell\Widgets;

abstract class BaseModifiedText implements Widget
{
    use RendersThemedWidget;

    protected Text $text;

    public function __construct(Theme $theme, Text $text)
    {
        $this->theme = $theme;
        $this->text = $text;
    }

    public static function create(Theme $theme, array $options = []): Widget
    {
        return new static(
            $theme,
            Widgets::make(
                'text',
                array_merge($options, ['modifier' => static::modifierMethodName()])
            )
        );
    }

    public function render($data = null): string
    {
        return $this->text->render($data);
    }

    abstract protected static function modifierMethodName(): string;
}
