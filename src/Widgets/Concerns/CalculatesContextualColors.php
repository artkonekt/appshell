<?php

declare(strict_types=1);

/**
 * Contains the CalculatesContextualColors trait.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-03-14
 *
 */

namespace Konekt\AppShell\Widgets\Concerns;

use Konekt\AppShell\Theme\ThemeColor;
use Konekt\AppShell\Traits\ManipulatesColors;
use Konekt\AppShell\Widgets\Dto\ColorAttributes;

trait CalculatesContextualColors
{
    use ManipulatesColors;

    protected function parseColorDefinition(
        $definition,
        $value = null,
        string $fallback = ThemeColor::PRIMARY
    ): ColorAttributes {
        if (null === $definition) {
            return new ColorAttributes(ThemeColor::create($fallback), null);
        }

        if (is_string($definition)) {
            return $this->fromColorString($definition);
        }

        if (is_array($definition)) {
            if (isset($definition['bool'])) {
                return $this->byBooleanExpression($definition['bool'], $value);
            }
            // Additional magic here
        }

        return new ColorAttributes(ThemeColor::create($fallback), null);
    }

    private function byBooleanExpression(array $definition, $value): ColorAttributes
    {
        return $this->fromColorString(
            (bool) $value ? $definition[0] ?? null : $definition[1] ?? null
        );
    }

    private function fromColorString(?string $color, $setForegroundColor = false): ColorAttributes
    {
        if (null === $color) {
            return new ColorAttributes(ThemeColor::NONE(), null);
        }

        if (self::isThemeColor($color)) {
            return new ColorAttributes(ThemeColor::create($color), null);
        }

        //assume they've passed an html color red or #ff0000
        if ($setForegroundColor) {
            $style = "color: $color;";
        } else {
            $style = "background-color: $color;";
            if (self::needsWhiteText($color)) {
                $style .= 'color: #FFFFFF;';
            }
        }

        return new ColorAttributes(ThemeColor::NONE(), $style);
    }
}
