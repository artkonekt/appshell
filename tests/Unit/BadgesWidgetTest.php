<?php

declare(strict_types=1);

/**
 * Contains the BadgesWidgetTest class.
 *
 * @copyright   Copyright (c) 2022 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2022-03-09
 *
 */

namespace Konekt\AppShell\Tests\Unit;

use Konekt\AppShell\Tests\TestCase;
use Konekt\AppShell\Theme\AppShell3Theme;
use Konekt\AppShell\Widgets\Badges;

class BadgesWidgetTest extends TestCase
{
    /** @test */
    public function it_can_render_a_default_text_for_empty_lists()
    {
        $badges = Badges::create(new AppShell3Theme(), ['empty' => ['text' => 'Nothing here', 'color' => 'dark']]);
        $html = trim($badges->render([]));
        $this->assertStringContainsString('bg-dark', $html);
        $this->assertStringContainsString('Nothing here</', $html);
    }
}
