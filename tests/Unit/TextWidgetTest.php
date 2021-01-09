<?php

declare(strict_types=1);

/**
 * Contains the TextWidgetTest class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-01-09
 *
 */

namespace Konekt\AppShell\Tests\Unit;

use Illuminate\Support\Facades\Route;
use Konekt\AppShell\Models\User;
use Konekt\AppShell\Tests\TestCase;
use Konekt\AppShell\Theme\AppShellTheme;
use Konekt\AppShell\Widgets\Text;

class TextWidgetTest extends TestCase
{
    /** @test */
    public function it_can_simply_echo_the_given_text()
    {
        $text = Text::create(new AppShellTheme(), ['text' => 'Hello Mirr-murr']);
        $this->assertEquals('Hello Mirr-murr', trim($text->render()));
    }

    /** @test */
    public function it_can_wrap_the_text_into_an_html_tag()
    {
        $text = Text::create(new AppShellTheme(), ['text' => 'Yo, Frakk!', 'wrap' => 'span']);
        $this->assertEquals('<span>Yo, Frakk!</span>', trim($text->render()));
    }

    /** @test */
    public function classes_can_be_added_to_the_wrapper_tag()
    {
        $text = Text::create(new AppShellTheme(), ['text' => 'Gemini 6', 'wrap' => 'span', 'class' => 'text-muted']);
        $this->assertEquals('<span class="text-muted">Gemini 6</span>', trim($text->render()));
    }

    /** @test */
    public function style_can_be_added_to_the_wrapper_tag()
    {
        $text = Text::create(new AppShellTheme(), ['text' => 'Gemini 6', 'wrap' => 'span', 'style' => 'color: red']);
        $this->assertEquals('<span style="color: red">Gemini 6</span>', trim($text->render()));
    }

    /** @test */
    public function title_can_be_added_to_the_wrapper_tag()
    {
        $text = Text::create(new AppShellTheme(), ['text' => 'Gemini 6', 'wrap' => 'span', 'title' => 'Flew after Gemini 7!']);
        $this->assertEquals('<span title="Flew after Gemini 7!">Gemini 6</span>', trim($text->render()));
    }

    /** @test */
    public function multiple_attributes_can_be_added_to_the_wrapper_tag()
    {
        $text = Text::create(
            new AppShellTheme(),
            [
                'text' => 'Vostok-3',
                'wrap' => 'div',
                'title' => 'August 11, 1962',
                'class' => 'text-primary',
                'style' => 'background-color: black'
            ]
        );
        $html = trim($text->render());
        $this->assertStringContainsString('<div', $html);
        $this->assertStringContainsString('title="August 11, 1962"', $html);
        $this->assertStringContainsString('class="text-primary"', $html);
        $this->assertStringContainsString('style="background-color: black"', $html);
        $this->assertStringContainsString('</div>', $html);
    }

    /** @test */
    public function it_can_render_the_given_field_of_a_model_as_text()
    {
        $text = Text::create(new AppShellTheme(), ['text' => '$model.name']);
        $user = new User(['name' => 'Mirr Murr']);
        $this->assertEquals('Mirr Murr', trim($text->render($user)));
    }

    /** @test */
    public function it_can_render_a_route_as_text()
    {
        $text = Text::create(new AppShellTheme(), ['text' => ['route' => 'testing-users']]);
        $this->assertEquals('http://localhost/tesing-users', trim($text->render()));
    }

    /** @test */
    public function it_can_render_a_route_with_params_as_text()
    {
        $text = Text::create(new AppShellTheme(), ['text' => ['route' => 'testing-user', 'parameters' => ['$model']]]);
        $user = new User(['name' => 'Mirr Murr']);
        $user->id = 2733;
        $this->assertEquals('http://localhost/tesing-users/2733', trim($text->render($user)));
    }

    public function setUp(): void
    {
        parent::setUp();

        Route::get('/tesing-users', ['as' => 'testing-users']);
        Route::get('/tesing-users/{user}', ['as' => 'testing-user']);
    }
}
