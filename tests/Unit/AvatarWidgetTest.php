<?php

declare(strict_types=1);

/**
 * Contains the AvatarWidgetTest class.
 *
 * @copyright   Copyright (c) 2025 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2025-01-09
 *
 */

namespace Konekt\AppShell\Tests\Unit;

use Illuminate\Support\Facades\Route;
use Konekt\AppShell\Tests\TestCase;
use Konekt\AppShell\Theme\AppShellTheme;
use Konekt\AppShell\Widgets\Avatar;

class AvatarWidgetTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Route::get('/avatar-route-prefix/{user}', ['as' => 'test.user.show']);
    }

    /** @test */
    public function it_renders_a_default_when_the_model_is_null()
    {
        $widget = Avatar::create(new AppShellTheme());

        $html = trim($widget->render());
        $this->assertStringContainsString('<img', $html);
        $this->assertStringContainsString('src="https://www.gravatar.com/avatar/00000000000000000000000000000000', $html);
    }

    /** @test */
    public function it_renders_the_md5_of_the_models_email_when_given()
    {
        $user = new \stdClass();
        $user->email = 'test@example.com';
        $md5 = md5($user->email);
        $widget = Avatar::create(new AppShellTheme());

        $html = trim($widget->render($user));
        $this->assertStringContainsString('<img', $html);
        $this->assertStringContainsString($md5, $html);
    }

    /** @test */
    public function it_substitutes_placeholders_when_given()
    {
        $user = new \stdClass();
        $user->email = 'giovanni.gatto@catsville.com';
        $md5 = md5($user->email);
        $order = new \stdClass();
        $order->user = $user;
        $widget = Avatar::create(new AppShellTheme(), ['model' => '$model.user']);

        $html = trim($widget->render($order));
        $this->assertStringContainsString('<img', $html);
        $this->assertStringContainsString($md5, $html);
    }

    /** @test */
    public function it_does_not_render_a_link_if_such_parameter_was_not_passed()
    {
        $user = new \stdClass();
        $user->email = 'test@example.com';
        $widget = Avatar::create(new AppShellTheme());

        $html = trim($widget->render($user));
        $this->assertStringNotContainsString('<a', $html);
        $this->assertStringNotContainsString('href="', $html);
    }

    /** @test */
    public function a_link_can_be_rendered_optionally()
    {
        $user = new \stdClass();
        $user->email = 'giovanni.gatto@catsville.com';
        $user->id = 35688;
        $md5 = md5($user->email);

        $widget = Avatar::create(new AppShellTheme(), ['url' => 'https://penny.cz']);

        $html = trim($widget->render($user));
        $this->assertStringContainsString('<img ', $html);
        $this->assertStringContainsString($md5, $html);
        $this->assertStringContainsString('<a href="https://penny.cz">', $html);
    }

    /** @test */
    public function a_route_based_link_can_be_rendered_optionally()
    {
        $user = new \stdClass();
        $user->email = 'giovanni.gatto@catsville.com';
        $user->id = 35688;
        $md5 = md5($user->email);

        $widget = Avatar::create(new AppShellTheme(), ['url' => ['route' => 'test.user.show', 'parameters' => ['$model.id']]]);

        $html = trim($widget->render($user));
        $this->assertStringContainsString('<img ', $html);
        $this->assertStringContainsString($md5, $html);
        $this->assertStringContainsString('<a href="http://localhost/avatar-route-prefix/35688">', $html);
    }
}
