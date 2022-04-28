<?php

declare(strict_types=1);

/**
 * Contains the RawHtmlTest class.
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
use Konekt\AppShell\Widgets\RawHtml;

class RawHtmlTest extends TestCase
{
    /** @test */
    public function it_can_simply_echo_the_given_html()
    {
        $raw = RawHtml::create(new AppShell3Theme(), ['html' => '<div id="123">Hahaha</div>']);
        $this->assertEquals('<div id="123">Hahaha</div>', trim($raw->render()));
    }

    /** @test */
    public function it_can_render_the_given_field_of_a_model_within_the_html()
    {
        $html = RawHtml::create(new AppShell3Theme(), ['html' => '<img src="1.jpg" title="$model.name" />']);
        $user = new User(['name' => 'Maulwurf']);
        $this->assertEquals('<img src="1.jpg" title="Maulwurf" />', trim($html->render($user)));
    }

    /** @test */
    public function it_can_render_the_result_of_a_method_of_a_model_within_the_html()
    {
        $html = RawHtml::create(new AppShell3Theme(), ['html' => '<input value="$model.getEmailForPasswordReset()" >']);
        $user = new User(['email' => 'yo@hey.com']);

        $this->assertEquals('<input value="yo@hey.com" >', trim($html->render($user)));
    }

    /** @test */
    public function it_can_render_multiple_fields_of_the_model_into_the_html()
    {
        $html = RawHtml::create(new AppShell3Theme(), ['html' => '<label>$model.name</label><span>$model.getEmailForPasswordReset()</span>']);
        $user = new User(['name' => 'Johnny', 'email' => 'johnny@macaroni.it']);

        $this->assertEquals('<label>Johnny</label><span>johnny@macaroni.it</span>', trim($html->render($user)));
    }

    /** @test */
    public function it_can_render_fields_containing_underscores_of_the_model_into_the_html()
    {
        $html = RawHtml::create(new AppShell3Theme(), ['html' => '<span>$model.is_active</span>']);
        $user = new User(['is_active' => 'true']);

        $this->assertEquals('<span>true</span>', trim($html->render($user)));
    }

    /** @test */
    public function a_modifier_can_be_passed_to_manipulate_the_output_of_the_html()
    {
        $html = RawHtml::create(new AppShell3Theme(), ['html' => '<SPAN>giovanni gatto</SPAN>', 'modifier' => 'lowercase']);
        $this->assertEquals('<span>giovanni gatto</span>', trim($html->render()));
    }

    /** @test */
    public function it_can_be_rendered_conditinally()
    {
        $html = RawHtml::create(new AppShell3Theme(), ['html' => '<img src="/some.jpg" />', 'onlyIf' => '$model.is_active']);

        $this->assertEmpty(trim($html->render(new User(['is_active' => false]))));
        $this->assertEquals('<img src="/some.jpg" />', $html->render(new User(['is_active' => true])));
    }
}
