<?php

declare(strict_types=1);

/**
 * Contains the EnumColorTest class.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-03-10
 *
 */

namespace Konekt\AppShell\Tests\Unit;

use Konekt\AppShell\EnumColors;
use Konekt\AppShell\Tests\MoodForColoring;
use Konekt\AppShell\Tests\TestCase;
use Konekt\AppShell\Theme\ThemeColor;

class EnumColorTest extends TestCase
{
    /** @test */
    public function theme_colors_for_an_enum_can_be_set()
    {
        EnumColors::registerEnumColor(MoodForColoring::class, [
            MoodForColoring::HAPPY => ThemeColor::SUCCESS(),
            MoodForColoring::IMOK => ThemeColor::INFO(),
            MoodForColoring::MEH => ThemeColor::LIGHT(),
            MoodForColoring::TIRED => ThemeColor::WARNING(),
            MoodForColoring::EXHAUSTED => ThemeColor::DANGER(),
        ]);

        $this->assertEquals(ThemeColor::DANGER(), EnumColors::colorOf(MoodForColoring::EXHAUSTED()));
        $this->assertEquals(ThemeColor::WARNING(), EnumColors::colorOf(MoodForColoring::TIRED()));
        $this->assertEquals(ThemeColor::LIGHT(), EnumColors::colorOf(MoodForColoring::MEH()));
        $this->assertEquals(ThemeColor::INFO(), EnumColors::colorOf(MoodForColoring::IMOK()));
        $this->assertEquals(ThemeColor::SUCCESS(), EnumColors::colorOf(MoodForColoring::HAPPY()));
    }

    /** @test */
    public function hex_colors_for_an_enum_can_be_set()
    {
        EnumColors::registerEnumColor(MoodForColoring::class, [
            MoodForColoring::HAPPY => "#25FF62",
            MoodForColoring::IMOK => '#3CDFDC',
            MoodForColoring::MEH => '#D0A1B8',
            MoodForColoring::TIRED => '#EEE81E',
            MoodForColoring::EXHAUSTED => '#EE391E',
        ]);

        $this->assertEquals('#EE391E', EnumColors::colorOf(MoodForColoring::EXHAUSTED()));
        $this->assertEquals('#EEE81E', EnumColors::colorOf(MoodForColoring::TIRED()));
        $this->assertEquals('#D0A1B8', EnumColors::colorOf(MoodForColoring::MEH()));
        $this->assertEquals('#3CDFDC', EnumColors::colorOf(MoodForColoring::IMOK()));
        $this->assertEquals('#25FF62', EnumColors::colorOf(MoodForColoring::HAPPY()));
    }

    /** @test */
    public function the_enum_color_helper_can_return_the_registered_values()
    {
        EnumColors::registerEnumColor(MoodForColoring::class, [
            MoodForColoring::HAPPY => ThemeColor::SUCCESS(),
            MoodForColoring::IMOK => '#3CDFDC',
            MoodForColoring::MEH => '#D0A1B8',
            MoodForColoring::TIRED => ThemeColor::WARNING(),
            MoodForColoring::EXHAUSTED => ThemeColor::DANGER(),
        ]);

        $this->assertEquals(ThemeColor::DANGER(), enum_color(MoodForColoring::EXHAUSTED()));
        $this->assertEquals(ThemeColor::WARNING(), enum_color(MoodForColoring::TIRED()));
        $this->assertEquals('#D0A1B8', enum_color(MoodForColoring::MEH()));
        $this->assertEquals('#3CDFDC', enum_color(MoodForColoring::IMOK()));
        $this->assertEquals(ThemeColor::SUCCESS(), enum_color(MoodForColoring::HAPPY()));
    }
}
