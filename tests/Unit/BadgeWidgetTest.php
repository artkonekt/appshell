<?php

declare(strict_types=1);

/**
 * Contains the BadgeWidgetTest class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-01-10
 *
 */

namespace Konekt\AppShell\Tests\Unit;

use Konekt\AppShell\Tests\TestCase;
use Konekt\AppShell\Theme\AppShell3Theme;
use Konekt\AppShell\Widgets\Badge;

class BadgeWidgetTest extends TestCase
{
    /** @test */
    public function it_can_render_a_simple_static_text_as_a_badge()
    {
        $text = Badge::create(new AppShell3Theme(), ['text' => 'Hot Deal']);
        $html = trim($text->render());
        $this->assertStringContainsString('class="badge rounded-pill', $html);
        $this->assertStringContainsString('Hot Deal</', $html);
    }

    /** @test */
    public function badge_color_can_be_specified()
    {
        $text = Badge::create(new AppShell3Theme(), ['text' => 'Expired', 'color' => 'danger']);
        $html = trim($text->render());
        $this->assertStringContainsString('class="badge rounded-pill bg-danger', $html);
        $this->assertStringContainsString('Expired</', $html);
    }

    /** @test */
    public function non_semantic_badge_color_will_be_rendered_as_background_color()
    {
        $text = Badge::create(new AppShell3Theme(), ['text' => 'Lollobrigida', 'color' => '#EE1212']);
        $html = trim($text->render());
        $this->assertStringContainsString('class="badge rounded-pill', $html);
        $this->assertStringNotContainsString('badge-primary', $html);
        $this->assertStringContainsString('style="', $html);
        $this->assertStringContainsString('background-color: #EE1212', $html);
        $this->assertStringContainsString('Lollobrigida</', $html);
    }

    /** @test */
    public function it_applies_white_text_if_black_can_not_be_read_on_explicit_bg_color()
    {
        $text = Badge::create(new AppShell3Theme(), ['text' => 'McQueen', 'color' => '#333333']);
        $html = trim($text->render());
        $this->assertStringContainsString('background-color: #333333', $html);
        $this->assertStringContainsString('color: #FFFFFF', $html);
    }
}
