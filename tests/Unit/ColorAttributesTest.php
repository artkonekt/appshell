<?php

declare(strict_types=1);

/**
 * Contains the ColorAttributesTest class.
 *
 * @copyright   Copyright (c) 2022 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2022-11-23
 *
 */

namespace Konekt\AppShell\Tests\Unit;

use Konekt\AppShell\Tests\TestCase;
use Konekt\AppShell\Theme\ThemeColor;
use Konekt\AppShell\Widgets\Dto\ColorAttributes;

class ColorAttributesTest extends TestCase
{
    /** @test */
    public function it_is_empty_if_theme_color_is_none_and_no_style_gets_set()
    {
        $attr = new ColorAttributes(ThemeColor::NONE(), null);

        $this->assertTrue($attr->isEmpty());
    }

    /** @test */
    public function it_is_not_empty_if_a_non_none_theme_color_is_set()
    {
        foreach (ThemeColor::values() as $themeColor) {
            if (ThemeColor::NONE !== $themeColor) {
                $this->assertFalse(
                    (new ColorAttributes(ThemeColor::create($themeColor), null))->isEmpty()
                );
            }
        }
    }

    /** @test */
    public function it_is_not_empty_if_a_none_theme_color_is_set_but_there_is_a_style_set()
    {
        $attr = new ColorAttributes(ThemeColor::NONE(), 'color: red;');
        $this->assertTrue($attr->isNotEmpty());
        $this->assertFalse($attr->isEmpty());
    }
}
