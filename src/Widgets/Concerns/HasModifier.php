<?php

declare(strict_types=1);

/**
 * Contains the HasModifier trait.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-10-10
 *
 */

namespace Konekt\AppShell\Widgets\Concerns;

use Konekt\AppShell\WidgetModifiers;

trait HasModifier
{
    /** @var null|string|callable */
    private $modifier = null;

    public function setModifier($modifier): void
    {
        $this->modifier = $modifier;
    }

    protected function modify($text): string
    {
        if (null === $this->modifier) {
            return (string) $text;
        }

        if (is_string($this->modifier) && WidgetModifiers::exists($this->modifier)) {
            return WidgetModifiers::make($this->modifier)->handle($text);
        }

        return (string) call_user_func($this->modifier, $text);
    }
}
