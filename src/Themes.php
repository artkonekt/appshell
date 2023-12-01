<?php

declare(strict_types=1);

/**
 * Contains the Themes class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-03-21
 *
 */

namespace Konekt\AppShell;

use Konekt\AppShell\Contracts\Theme;
use Konekt\AppShell\Exceptions\NonExistentThemeException;
use Konekt\Extend\Concerns\HasRegistry;
use Konekt\Extend\Concerns\RequiresClassOrInterface;
use Konekt\Extend\Contracts\Registry;

final class Themes implements Registry
{
    use HasRegistry;
    use RequiresClassOrInterface;

    protected static string $requiredInterface = Theme::class;

    public static function make(string $id, array $parameters = []): Theme
    {
        $themeClass = self::getClassOf($id);

        if (null === $themeClass && is_string($fallBackId = config('konekt.app_shell.ui.theme'))) {
            // Falling back to the default theme in the config
            $themeClass = self::getClassOf($fallBackId);
            if (function_exists('flash')) {
                flash()->warning(
                    __(
                        'There is no theme found with id :theme_id. Falling back to default. Check your application settings.',
                        ['theme_id' => $id]
                    )
                );
            }
        }

        if (null === $themeClass) {
            throw new NonExistentThemeException(
                "No theme is registered with the id `$id`."
            );
        }

        return app()->make($themeClass, $parameters);
    }
}
