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
use Konekt\AppShell\Exceptions\MissingWidgetFileException;
use Konekt\AppShell\Widgets\UnknownWidget;
use Konekt\Extend\Concerns\HasRegistry;
use Konekt\Extend\Concerns\RequiresClassOrInterface;
use Konekt\Extend\Contracts\Registry;

final class Widgets implements Registry
{
    use HasRegistry;
    use RequiresClassOrInterface;

    protected static string $requiredInterface = Widget::class;

    private static array $namespaces = [];

    private static array $widgetCache = [];

    public static function registerWidgetNamespace(string $namespace, string $folder): void
    {
        self::$namespaces[$namespace] = Str::endsWith($folder, '/') ? Str::replaceLast('/', '', $folder) : $folder;
    }

    public static function load(string $widget, ?Theme $theme = null): Widget
    {
        if (!isset(self::$widgetCache[$widget])) {
            self::$widgetCache[$widget] = require self::resolveUiPath($widget);
            if (!isset(self::$widgetCache[$widget]['options'])) {
                self::$widgetCache[$widget]['options'] = [];
            }
        }

        return self::make(self::$widgetCache[$widget]['type'], self::$widgetCache[$widget]['options'], $theme);
    }

    public static function make(string $id, array $parameters = [], ?Theme $theme = null): Widget
    {
        $widgetClass = self::getClassOf($id) ?? UnknownWidget::class;

        if (UnknownWidget::class === $widgetClass) {
            $parameters = array_merge($parameters, ['widget' => $id]);
        }

        return $widgetClass::create($theme ?? theme(), $parameters);
    }

    /*
     * Locate 'appshell::user.index.table' like:
     *      -> resources/widgets/vendor/appshell/user/index/table.widget.php
     *      -> <appshell_module_root>/resources/widgets/user/index/table.widget.php
     *   and return the first path where the file exists
     *
     * UI name without namespace, eg.: 'invoice.index.table':
     *      -> resources/widgets/invoice/index/table.widget.php
     */
    private static function resolveUiPath(string $widget): string
    {
        if (false === strpos($widget, '::')) {
            $namespace = null;
            $rawPath = $widget;
        } else {
            $parts = explode('::', $widget);
            // sanitize namespace
            $namespace = str_replace(
                ['../', '..', '/', '.', ':', '\\'],
                ['', '', '_', '_', '_', ''],
                filter_var($parts[0], FILTER_SANITIZE_STRING)
            );
            $rawPath = $parts[1];
        }

        $relativePath = str_replace(['../','.'], ['', '/'], $rawPath) . '.widget.php';

        if (null === $namespace) {
            $paths[] = resource_path("widgets/$relativePath");
        } else {
            $paths[] = resource_path("widgets/vendor/$namespace/$relativePath");
            if (isset(self::$namespaces[$namespace])) {
                $paths[] = self::$namespaces[$namespace] . "/$relativePath";
            }
        }

        foreach ($paths as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }

        throw new MissingWidgetFileException($widget, $paths);
    }
}
