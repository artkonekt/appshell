<?php

declare(strict_types=1);

namespace Konekt\AppShell\Tests\Feature;

use Konekt\AppShell\Tests\TestCase;
use Konekt\Gears\Facades\Settings;

class SettingsTest extends TestCase
{
    /** @test */
    public function guests_can_not_access_the_settings_resource()
    {
        $response = $this->get(route('appshell.settings.index'));
        $response->assertStatus(302)->assertRedirect(route('login'));

        $response = $this->put(route('appshell.settings.update'));
        $response->assertStatus(302)->assertRedirect(route('login'));
    }

    /** @test */
    public function it_can_display_the_settings_page_for_the_logged_in_admin()
    {
        $response = $this->actingAs($this->adminUser)->get(route('appshell.settings.index'));

        $response->assertStatus(200);
        $response->assertSee('General Settings');
        $response->assertSee('Save settings');
    }

    /** @test */
    public function it_can_update_the_settings()
    {
        $response = $this->actingAs($this->adminUser)->put(route('appshell.settings.update'), [
            'settings' => [
                'appshell.ui.name' => 'App name is awesome'
            ]
        ]);

        $response->assertStatus(302)->assertRedirect(route('appshell.settings.index'));
        $this->assertEquals('App name is awesome', Settings::get('appshell.ui.name'));
    }
}
