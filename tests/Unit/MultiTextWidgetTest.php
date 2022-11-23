<?php

declare(strict_types=1);

/**
 * Contains the MultiTextWidgetTest class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-10-10
 *
 */

namespace Konekt\AppShell\Tests\Unit;

use Konekt\AppShell\Models\User;
use Konekt\AppShell\Tests\TestCase;
use Konekt\AppShell\Theme\AppShell3Theme;
use Konekt\AppShell\Widgets\MultiText;

class MultiTextWidgetTest extends TestCase
{
    /** @test */
    public function it_can_render_two_lines_of_text()
    {
        $widget = MultiText::create(new AppShell3Theme(), [
            'primary' => ['text' => 'First here'],
            'secondary' => ['text' => 'Second there'],
        ]);

        $html = $widget->render();
        $this->assertStringContainsString('First here', $html);
        $this->assertStringContainsString('Second there', $html);
    }

    /** @test */
    public function the_secondary_widget_can_be_null()
    {
        $widget = MultiText::create(new AppShell3Theme(), [
            'primary' => ['text' => 'First here'],
            'secondary' => null,
        ]);

        $model = new User(['email' => 'this@notvisible.com']);
        $html = $widget->render($model);
        $this->assertStringContainsString('First here', $html);
        $this->assertStringNotContainsString($model->email, $html);
    }

    /** @test */
    public function it_can_render_extra_text_at_the_end_of_the_primary_widget()
    {
        $widget = MultiText::create(new AppShell3Theme(), [
            'primary' => [
                'text' => 'Some text',
                'extras' => [['text' => '#123']]
            ],
            'secondary' => ['text' => 'Meh'],
        ]);

        $html = $widget->render();
        $this->assertStringContainsString('<span class="text-muted">#123', $html);
    }

    /** @test */
    public function it_can_render_an_icon_in_the_extra_widget()
    {
        $widget = MultiText::create(new AppShell3Theme(), [
            'primary' => [
                'text' => 'Some text',
                'extras' => [['icon' => 'user']]
            ],
            'secondary' => ['text' => 'Meh'],
        ]);

        $html = $widget->render();
        $this->assertStringContainsString('<i class="zmdi zmdi-account-circle text-muted"', $html);
    }

    /** @test */
    public function it_can_render_raw_html_in_the_extra_widget()
    {
        $widget = MultiText::create(new AppShell3Theme(), [
            'primary' => [
                'text' => 'Some text',
                'extras' => [['html' => '<img src="a.jpg"` />']]
            ],
            'secondary' => ['text' => 'Meh'],
        ]);

        $html = $widget->render();
        $this->assertStringContainsString('<img src="a.jpg"', $html);
    }

    /** @test */
    public function it_can_render_an_extra_text_and_and_extra_icon()
    {
        $widget = MultiText::create(new AppShell3Theme(), [
            'primary' => [
                'text' => 'Some text',
                'extras' => [['text' => 'Priority:'], ['icon' => 'user']]
            ],
            'secondary' => ['text' => 'Meh'],
        ]);

        $html = $widget->render();
        $this->assertStringContainsString('<span class="text-muted">Priority:</span>', $html);
        $this->assertStringContainsString('<i class="zmdi zmdi-account-circle text-muted"', $html);
    }
}
