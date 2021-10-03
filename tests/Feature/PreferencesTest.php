<?php

declare(strict_types=1);
/**
 * Contains the PreferencesTest class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-09-24
 *
 */

namespace Konekt\AppShell\Tests\Feature;

use Konekt\AppShell\Tests\TestCase;

class PreferencesTest extends TestCase
{
    /** @test */
    public function guests_can_not_access_the_preferences()
    {
        $response = $this->get(route('appshell.preferences.index'));
        $response->assertStatus(302)->assertRedirect(route('login'));

        $response = $this->put(route('appshell.preferences.update'));
        $response->assertStatus(302)->assertRedirect(route('login'));
    }

    /** @test */
    public function an_admin_can_see_the_preferences_page()
    {
        $response = $this->actingAs($this->adminUser)->get(route('appshell.preferences.index'));

        $response->assertStatus(200);
        $response->assertSee('Preferences');
        $response->assertSee('Save preferences');
    }

    /** @test */
    public function a_normal_user_can_see_the_preferences_page()
    {
        $response = $this->actingAs($this->normalUser)->get(route('appshell.preferences.index'));

        $response->assertStatus(200);
        $response->assertSee('Preferences');
        $response->assertSee('Save preferences');
    }
}
