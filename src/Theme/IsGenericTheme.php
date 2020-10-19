<?php
/**
 * Contains the IsGenericTheme trait.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-03-22
 *
 */

namespace Konekt\AppShell\Theme;

use Konekt\AppShell\Exceptions\UnknownLayoutException;

trait IsGenericTheme
{
    public static function getName(): string
    {
        return self::$name;
    }

    public function layout(string $variant): string
    {
        if (!isset($this->layouts[$variant])) {
            throw new UnknownLayoutException(
                sprintf(
                    'Layout variant %s does not exist within the %s theme',
                    $variant,
                    $this->getName()
                )
            );
        }

        return $this->layouts[$variant];
    }

    public function themeColorToHex(?string $themeColorName): string
    {
        if (!isset($this->themeColors[$themeColorName])) {
            // #777: last resort fallback. Can be read on white, black and light gray backgrounds.
            return strtolower($this->themeColors[ThemeColor::defaultValue()] ?? '#777');
        }

        return strtolower($this->themeColors[$themeColorName]);
    }

    public function hexToThemeColor(string $hexColor): ?string
    {
        foreach (ThemeColor::values() as $themeColor) {
            if (strtolower($hexColor) === $this->themeColorToHex($themeColor)) {
                return $themeColor;
            }
        }

        return null;
    }

    public function viewNamespace(): string
    {
        return self::$viewNamespace;
    }
}
