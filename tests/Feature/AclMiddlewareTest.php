<?php

declare(strict_types=1);

/**
 * Contains the AclMiddlewareTest class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-09-27
 *
 */

namespace Konekt\AppShell\Tests\Feature;

use Illuminate\Support\Facades\Route;
use Konekt\Acl\Models\Permission;
use Konekt\Acl\Models\Role;
use Konekt\AppShell\Tests\Dummies\IssueTypeController;
use Konekt\AppShell\Tests\TestCase;

class AclMiddlewareTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Role::findByName('admin')->givePermissionTo(
            Permission::create(['name' => 'create issue types'])
        );

        Route::resource('issue-types', IssueTypeController::class, ['middleware' => ['web', 'auth', 'acl']])
             ->parameters(['issue-types' => 'issueType']);
    }

    /** @test */
    public function guests_can_not_access_the_issue_type_resource()
    {
        $response = $this->get(route('issue-types.create'));

        $response->assertStatus(302)->assertRedirect(route('login'));
    }

    /** @test */
    public function admins_can_access_the_issue_type_resource()
    {
        $response = $this->actingAs($this->adminUser)->get(route('issue-types.create'));

        $response->assertStatus(200);
    }
}
