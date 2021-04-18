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

use Illuminate\Support\Str;
use Konekt\AppShell\Contracts\Theme;
use Konekt\AppShell\Contracts\Widget;
use Konekt\AppShell\Exceptions\MissingUiFileException;
use Konekt\AppShell\Widgets\UnknownWidget;

final class Widgets
{
    private static array $registry = [];

    private static array $namespaces = [];

    private static array $widgetCache = [];

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

    public static function registerUiNamespace(string $namespace, string $folder): void
    {
        self::$namespaces[$namespace] = Str::endsWith($folder, '/') ? Str::replaceLast('/', '', $folder) : $folder;
    }

    public static function load(string $ui, ?Theme $theme = null): Widget
    {
        if (!isset(self::$widgetCache[$ui])) {
            self::$widgetCache[$ui] = require self::resolveUiPath($ui);
            if (!isset(self::$widgetCache[$ui]['options'])) {
                self::$widgetCache[$ui]['options'] = [];
            }
        }

        return self::make(self::$widgetCache[$ui]['type'], self::$widgetCache[$ui]['options'], $theme);
    }

    public static function make(string $type, array $options = [], ?Theme $theme = null): Widget
    {
        $widgetClass = self::getClass($type) ?? UnknownWidget::class;

        if (UnknownWidget::class === $widgetClass) {
            $options = array_merge($options, ['widget' => $type]);
        }

        return $widgetClass::create($theme ?? theme(), $options);
    }

    public static function getClass(string $id): ?string
    {
        return self::$registry[$id] ?? null;
    }

    /*
     * Locate 'appshell::user.index.table' like:
     *      -> resources/ui/vendor/appshell/user/index/table.ui.php
     *      -> <appshell_module_root>/resources/ui/user/index/table.ui.php
     *   and return the first path where the file exists
     *
     * UI name without namespace, eg.: 'invoice.index.table':
     *      -> resources/ui/invoice/index/table.ui.php
     */
    private static function resolveUiPath(string $ui): string
    {
        if (false === strpos($ui, '::')) {
            $namespace = null;
            $rawPath = $ui;
        } else {
            $parts = explode('::', $ui);
            // sanitize namespace
            $namespace = str_replace(
                ['../', '..', '/', '.', ':', '\\'],
                ['', '', '_', '_', '_', ''],
                filter_var($parts[0], FILTER_SANITIZE_STRING)
            );
            $rawPath = $parts[1];
        }

        $relativePath = str_replace(['../','.'], ['', '/'], $rawPath) . '.ui.php';

        if (null === $namespace) {
            $paths[] = resource_path("ui/$relativePath");
        } else {
            $paths[] = resource_path("ui/vendor/$namespace/$relativePath");
            if (isset(self::$namespaces[$namespace])) {
                $paths[] = self::$namespaces[$namespace] . "/$relativePath";
            }
        }

        foreach ($paths as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }

        throw new MissingUiFileException($ui, $paths);
    }
}
