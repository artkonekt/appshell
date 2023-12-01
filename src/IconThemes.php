<?php

declare(strict_types=1);

/**
 * Contains the IconThemes class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-10-18
 *
 */

namespace Konekt\AppShell;

use Konekt\AppShell\Contracts\IconTheme;
use Konekt\AppShell\Exceptions\NonExistentIconThemeException;
use Konekt\Extend\Concerns\HasRegistry;
use Konekt\Extend\Concerns\RequiresClassOrInterface;
use Konekt\Extend\Contracts\Registry;

final class IconThemes implements Registry
{
    use HasRegistry;
    use RequiresClassOrInterface;

    protected static string $requiredInterface = IconTheme::class;

    public static function make(string $id, array $parameters = []): IconTheme
    {
        $iconThemeClass = self::getClassOf($id);

        if (null === $iconThemeClass && is_string($fallBackId = config('konekt.app_shell.ui.icon_theme'))) {
            // Falling back to the default icon theme in the config
            $iconThemeClass = self::getClassOf($fallBackId);
            if (function_exists('flash')) {
                flash()->warning(
                    __(
                        'There is no icon theme found with id :icon_theme_id. Falling back to default. Check your application settings.',
                        ['icon_theme_id' => $id]
                    )
                );
            }
        }

        if (null === $iconThemeClass) {
            throw new NonExistentIconThemeException(
                "No icon theme is registered with the id `$id`."
            );
        }

        return app()->make($iconThemeClass);
    }
}
