<?php

declare(strict_types=1);

/**
 * Contains the LinkWidgetTest class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-01-09
 *
 */

namespace Konekt\AppShell\Tests\Unit;

use Illuminate\Support\Facades\Route;
use Konekt\AppShell\Tests\Dummies\Parrot;
use Konekt\AppShell\Tests\TestCase;
use Konekt\AppShell\Theme\AppShellTheme;
use Konekt\AppShell\Widgets\Link;

class LinkWidgetTest extends TestCase
{
    /** @test */
    public function it_can_generate_a_link_from_two_field_of_the_model()
    {
        $link = Link::create(new AppShellTheme(), ['text' => '$model.name', 'url' => '$model.link']);
        $html = $link->render(new Parrot('Pakito', 'https://pakito.parrot'));

        $this->assertStringContainsString('href="https://pakito.parrot', $html);
        $this->assertStringContainsString('>Pakito</a>', $html);
    }

    /** @test */
    public function it_can_generate_a_link_from_a_field_and_a_route()
    {
        $link = Link::create(new AppShellTheme(), [
            'text' => '$model.name',
            'url' => [
                'route' => 'pakito',
                'parameters' => ['$model'],
            ]
        ]);
        $html = $link->render(new Parrot('Pakito'));

        $this->assertStringContainsString('/parrots-route-prefix/', $html);
        $this->assertStringContainsString('>Pakito</a>', $html);
    }

    /** @test */
    public function it_can_generate_a_link_from_a_parametrized_url()
    {
        $link = Link::create(new AppShellTheme(), [
            'text' => '$model.name',
            'url' => [
                'path' => '/pakito',
                'parameters' => ['$model'],
            ]
        ]);
        $html = $link->render(new Parrot('Puffin'));

        $this->assertStringContainsString('/pakito/puffin', $html);
        $this->assertStringContainsString('>Puffin</a>', $html);
    }

    /** @test */
    public function it_can_resolve_a_model_field_as_in_the_route_link()
    {
        $link = Link::create(new AppShellTheme(), [
            'text' => 'Get The Puffin Link',
            'url' => '$model.link'
        ]);
        $html = $link->render(new Parrot('Puffin', 'http://only.puffin.gives.you.the.power.net'));

        $this->assertStringContainsString('href="http://only.puffin.gives.you.the.power.net"', $html);
        $this->assertStringContainsString('>Get The Puffin Link</a>', $html);
    }

    /** @test */
    public function static_text_can_be_used_as_text_or_as_link()
    {
        $link = Link::create(new AppShellTheme(), [
            'text' => 'Go To Signal',
            'url' => 'https://signal.org'
        ]);
        $html = $link->render(new Parrot('Puffin', 'http://only.puffin.gives.you.the.power.net'));

        $this->assertStringContainsString('href="https://signal.org"', $html);
        $this->assertStringContainsString('>Go To Signal</a>', $html);
    }

    /** @test */
    public function it_can_conditionally_render_the_link_based_on_a_can_condition()
    {
        $link = Link::create(new AppShellTheme(), [
            'text' => 'Go To Signal',
            'url' => 'https://signal.org',
            'onlyIfCan' => 'edit users'
        ]);

        $this->actingAs($this->normalUser);
        $html = $link->render();
        $this->assertStringNotContainsString('href="', $html);

        $this->actingAs($this->adminUser);
        $html = $link->render();
        $this->assertStringContainsString('href="', $html);
    }

    /** @test */
    public function inner_text_can_be_wrapped_in_an_html_tag()
    {
        $link = Link::create(new AppShellTheme(), [
            'text' => [
                'text' => 'Go To Signal',
                'wrap' => 'span',
            ],
            'url' => 'https://signal.org',
        ]);

        $html = $link->render();
        $this->assertStringContainsString('<span>', $html);
    }

    /** @test */
    public function class_can_be_added_to_the_inner_text_wrapper()
    {
        $link = Link::create(new AppShellTheme(), [
            'text' => [
                'text' => 'Go To Signal',
                'wrap' => 'span',
                'class' => 'text-muted'
            ],
            'url' => 'https://signal.org',
        ]);

        $html = $link->render();
        $this->assertStringContainsString('<span class="text-muted">', $html);
    }

    public function setUp(): void
    {
        parent::setUp();

        Route::get('/parrots-route-prefix/{parrot}', ['as' => 'pakito']);
    }
}
