<?php

namespace Konekt\AppShell\Tests\Feature;

use Konekt\AppShell\Models\User;
use Konekt\AppShell\Tests\TestCase;
use Konekt\User\Models\UserType;

class UserTest extends TestCase
{
    /** @var User */
    private $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::create([
            'type'     => UserType::CLIENT,
            'name'     => 'Batman',
            'email'    => 'bat@man.com',
            'password' => 'mustbeatleast7chars'
        ]);
    }

    /** @test */
    public function guests_can_not_access_the_user_resource()
    {
        $response = $this->get(route('appshell.user.index'));

        $response->assertStatus(302)->assertRedirect(route('login'));
    }

    /** @test */
    public function it_can_create_user()
    {
        $response = $this->actingAs($this->adminUser)->get(route('appshell.user.create'));

        $response->assertSee('Create new user');
        $response->assertSee('Create user');
        $response->assertSee('Full name');
        $response->assertSee('Enter password');
    }

    /** @test */
    public function it_can_store_user()
    {
        $this->actingAs($this->adminUser)->post(route('appshell.user.store'), [
            'name'     => 'Spiderman',
            'email'    => 'spider@man.com',
            'password' => 'mustbeatleast7chars',
            'type'     => UserType::ADMIN
        ]);

        $user = User::all()->last();

        $this->assertEquals(UserType::ADMIN, $user->type->value());
        $this->assertEquals('Spiderman', $user->name);
        $this->assertEquals('spider@man.com', $user->email);
    }

    /** @test */
    public function it_can_list_user()
    {
        $response = $this->actingAs($this->adminUser)->get(route('appshell.user.index'));

        $response->assertSee($this->user->name);
        $response->assertSee($this->user->email);
    }

    /** @test */
    public function it_can_edit_user()
    {
        $response = $this->actingAs($this->adminUser)->get(route('appshell.user.edit', $this->user));

        $response->assertSee("Editing " . $this->user->name);
    }

    /** @test */
    public function it_can_update_user()
    {
        $this->actingAs($this->adminUser)->put(route('appshell.user.update', $this->user), [
            'email' => 'changed@mail.com',
            'name'  => 'Awesome man',
            'type'  => UserType::ADMIN
        ]);

        $this->assertEquals('changed@mail.com', $this->user->fresh()->email);
        $this->assertEquals('Awesome man', $this->user->fresh()->name);
        $this->assertEquals(UserType::ADMIN, $this->user->fresh()->type);
    }

    /** @test */
    public function it_can_destroy_user()
    {
        $this->actingAs($this->adminUser)->delete(route('appshell.user.destroy', $this->user));

        $this->assertNull(User::find($this->user->id));
    }
}
