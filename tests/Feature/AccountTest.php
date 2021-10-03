<?php

declare(strict_types=1);

namespace Konekt\AppShell\Tests\Feature;

use Konekt\AppShell\Tests\TestCase;

class AccountTest extends TestCase
{
    /** @test */
    public function it_can_display_the_account_page_for_the_logged_in_admin()
    {
        $response = $this->actingAs($this->adminUser)->get(route('appshell.account.display'));

        $response->assertStatus(200);
        $response->assertSee('Display Name');
        $response->assertSee('New Password');
    }

    /** @test */
    public function guests_can_not_access_the_account_resource()
    {
        $response = $this->get(route('appshell.account.display'));

        $response->assertStatus(302)->assertRedirect(route('login'));

        $response = $this->put(route('appshell.account.display'));

        $response->assertStatus(302)->assertRedirect(route('login'));
    }

    /** @test */
    public function it_can_update_account()
    {
        $this->actingAs($this->adminUser)->put(route('appshell.account.save'), ['name' => 'Modified user name']);

        $this->assertEquals('Modified user name', $this->adminUser->fresh()->name);
    }
}
