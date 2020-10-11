<?php
/**
 * Contains the ColorHelper class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-03-22
 *
 */

namespace Konekt\AppShell\Helpers;

class ColorHelper
{
    /**
     * Returns whether the two colors provide enough contrast to be read on top of each other
     *
     * @param string $color1
     * @param string $color2
     *
     * @return bool
     */
    public function canBeReadTogether(string $color1, string $color2): bool
    {
        return $this->lumDiff($color1, $color2) > 4.3;
    }

    public function lumDiff(string $color1, string $color2): float
    {
        return $this->luminosityDifference(
            $this->red($color1),
            $this->green($color1),
            $this->blue($color1),
            $this->red($color2),
            $this->green($color2),
            $this->blue($color2)
        );
    }

    public function red(string $hexColor): int
    {
        return (int) base_convert(substr($hexColor, 1, 2), 16, 10);
    }

    public function green(string $hexColor): int
    {
        return (int) base_convert(substr($hexColor, 3, 2), 16, 10);
    }

    public function blue(string $hexColor): int
    {
        return (int) base_convert(substr($hexColor, 5, 2), 16, 10);
    }

    /**
     * Converts a hex color to rgba
     * @param string $hexColor eg. '#00ffff'
     * @param int    $alpha 0.00 - 1.00
     * @return string eg. 'rgba(0, 255, 255, 0.5)'
     */
    public function rgba(string $hexColor, float $alpha = 1): string
    {
        // fall back to 1 if out of range
        $alpha = (0 <= $alpha) && ($alpha <= 1) ? $alpha : 1;
        return sprintf(
            'rgba(%d, %d, %d, %.2f',
            $this->red($hexColor),
            $this->green($hexColor),
            $this->blue($hexColor),
            $alpha
        );
    }

    /**
     * Returns the luminosity difference between two colors.
     * Values above ~4.5 can be considered as good contrast
     *
     * @param int $r1
     * @param int $g1
     * @param int $b1
     * @param int $r2
     * @param int $g2
     * @param int $b2
     * @return float
     */
    private function luminosityDifference(int $r1, int $g1, int $b1, int $r2, int $g2, int $b2): float
    {
        $l1 = 0.2126 * pow($r1 / 255, 2.2) +
            0.7152 * pow($g1 / 255, 2.2) +
            0.0722 * pow($b1 / 255, 2.2);

        $l2 = 0.2126 * pow($r2 / 255, 2.2) +
            0.7152 * pow($g2 / 255, 2.2) +
            0.0722 * pow($b2 / 255, 2.2);

        if ($l1 > $l2) {
            return ($l1 + 0.05) / ($l2 + 0.05);
        }

        return ($l2 + 0.05) / ($l1 + 0.05);
    }
}
