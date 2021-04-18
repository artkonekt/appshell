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
    public function setUp(): void
    {
        parent::setUp();

        Route::get('/tesing-users', ['as' => 'testing-users']);
        Route::get('/tesing-users/{user}', ['as' => 'testing-user']);
    }
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
    public function it_can_render_the_result_of_a_method_of_a_model_as_text()
    {
        $text = Text::create(new AppShellTheme(), ['text' => '$model.getEmailForPasswordReset()']);
        $user = new User(['email' => 'yo@hey.com']);

        $this->assertEquals('yo@hey.com', trim($text->render($user)));
    }

    /** @test */
    public function it_can_render_multiple_fields_of_the_model_as_text()
    {
        $text = Text::create(new AppShellTheme(), ['text' => '$model.name: $model.getEmailForPasswordReset()']);
        $user = new User(['name' => 'Johnny', 'email' => 'johnny@macaroni.it']);

        $this->assertEquals('Johnny: johnny@macaroni.it', trim($text->render($user)));
    }

    /** @test */
    public function it_can_render_fields_containing_underscores_of_the_model_as_text()
    {
        $text = Text::create(new AppShellTheme(), ['text' => '$model.is_active']);
        $user = new User(['is_active' => 'true']);

        $this->assertEquals('true', trim($text->render($user)));
    }

    /** @test */
    public function it_can_render_a_combination_of_fields_and_methods_of_the_model_as_text()
    {
        $text = Text::create(new AppShellTheme(), ['text' => '$model.name | $model.email']);
        $user = new User(['name' => 'Johnny', 'email' => 'johnny@macaroni.it']);

        $this->assertEquals('Johnny | johnny@macaroni.it', trim($text->render($user)));
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

    /** @test */
    public function a_modifier_can_be_passed_to_manipulate_the_output_of_the_text()
    {
        $text = Text::create(new AppShellTheme(), ['text' => 'giovanni gatto', 'modifier' => 'ucwords']);
        $this->assertEquals('Giovanni Gatto', trim($text->render()));
    }

    /** @test */
    public function the_modifier_recognizes_registered_widget_modifiers()
    {
        $text = Text::create(new AppShellTheme(), ['text' => 'eleonora die hure', 'modifier' => 'uppercase']);
        $this->assertEquals('ELEONORA DIE HURE', trim($text->render()));

        $text = Text::create(new AppShellTheme(), ['text' => 'Eleonora Die Hure', 'modifier' => 'lowercase']);
        $this->assertEquals('eleonora die hure', $text->render());

        $text = Text::create(new AppShellTheme(), ['modifier' => 'bool2text:ja,nein']);
        $this->assertEquals('ja', $text->render(true));
        $this->assertEquals('nein', $text->render(false));

        $text = Text::create(new AppShellTheme(), ['modifier' => 'bool2text:yes,']);
        $this->assertEquals('yes', $text->render(1));
        $this->assertEquals('', $text->render(null));
    }
}
