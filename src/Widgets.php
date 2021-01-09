<?php

declare(strict_types=1);

/**
 * Contains the Widgets class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-01-09
 *
 */

namespace Konekt\AppShell;

use Konekt\AppShell\Contracts\Theme;
use Konekt\AppShell\Contracts\Widget;
use Konekt\AppShell\Widgets\UnknownWidget;

final class Widgets
{
    private static array $registry = [];

    public static function add(string $id, string $class): bool
    {
        if (array_key_exists($id, self::$registry)) {
            return false;
        }

        self::override($id, $class);

        return true;
    }

    public static function override(string $id, string $class): void
    {
        if (!in_array(Widget::class, class_implements($class))) {
            throw new \InvalidArgumentException(
                sprintf(
                    'The class you are trying to register (%s) as a widget, ' .
                    'must implement the %s interface.',
                    $class,
                    Widget::class
                )
            );
        }

        self::$registry[$id] = $class;
    }

    public static function make(string $id, array $options = [], ?Theme $theme = null): Widget
    {
        $widgetClass = self::getClass($id) ?? UnknownWidget::class;

        if (UnknownWidget::class === $widgetClass) {
            $options = array_merge($options, ['widget' => $id]);
        }

        return $widgetClass::create($theme ?? theme(), $options);
    }

    public static function getClass(string $id): ?string
    {
        return self::$registry[$id] ?? null;
    }
}
