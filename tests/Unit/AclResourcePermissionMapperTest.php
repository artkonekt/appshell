<?php

declare(strict_types=1);

/**
 * Contains the AclResourcePermissionMapperTest class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-09-26
 *
 */

namespace Konekt\AppShell\Tests\Unit;

use Konekt\AppShell\Acl\ResourcePermissionMapper;
use Konekt\AppShell\Tests\TestCase;

class AclResourcePermissionMapperTest extends TestCase
{
    /** @var ResourcePermissionMapper */
    private $mapper;

    public function setUp(): void
    {
        parent::setUp();
        $this->mapper = new ResourcePermissionMapper();
    }

    /** @test */
    public function it_is_a_singleton()
    {
        /** @var ResourcePermissionMapper $instance1 */
        $instance1 = $this->app->get(ResourcePermissionMapper::class);
        $instance1->overrideResourcePlural('yuxi', 'waxi');
        $this->assertEquals('waxi', $instance1->mappedResourceName('yuxi'));

        $instance2 = $this->app->get(ResourcePermissionMapper::class);
        $this->assertEquals('waxi', $instance2->mappedResourceName('yuxi'));
    }

    /** @test */
    public function it_converts_resource_names_to_snake_case_and_plural()
    {
        $this->assertEquals('products', $this->mapper->mappedResourceName('product'));
        $this->assertEquals('categories', $this->mapper->mappedResourceName('category'));
        $this->assertEquals('issue types', $this->mapper->mappedResourceName('issueType'));
        $this->assertEquals('absence types', $this->mapper->mappedResourceName('absence_type'));
        $this->assertEquals('absence types', $this->mapper->mappedResourceName('absenceType'));
        $this->assertEquals('absence types', $this->mapper->mappedResourceName('absence-type'));
        $this->assertEquals('absence types', $this->mapper->mappedResourceName('AbsenceType'));
        $this->assertEquals('absence types', $this->mapper->mappedResourceName('Absence Type'));
        $this->assertEquals('absence types', $this->mapper->mappedResourceName('absence type'));
        $this->assertEquals('taxa', $this->mapper->mappedResourceName('taxon'));
        $this->assertEquals('media', $this->mapper->mappedResourceName('medium'));
        $this->assertEquals('settings', $this->mapper->mappedResourceName('settings'));
    }

    /** @test */
    public function it_returns_list_as_verb_for_index_action()
    {
        $this->assertEquals(
            'list',
            $this->mapper->permissionVerbForAction('index')
        );
    }

    /** @test */
    public function it_returns_view_as_verb_for_show_action()
    {
        $this->assertEquals(
            'view',
            $this->mapper->permissionVerbForAction('show')
        );
    }

    /** @test */
    public function it_returns_create_as_verb_for_create_action()
    {
        $this->assertEquals(
            'create',
            $this->mapper->permissionVerbForAction('create')
        );
    }

    /** @test */
    public function it_returns_create_as_verb_for_store_action()
    {
        $this->assertEquals(
            'create',
            $this->mapper->permissionVerbForAction('store')
        );
    }

    /** @test */
    public function it_returns_edit_as_verb_for_edit_action()
    {
        $this->assertEquals(
            'edit',
            $this->mapper->permissionVerbForAction('edit')
        );
    }

    /** @test */
    public function it_returns_edit_as_verb_for_update_action()
    {
        $this->assertEquals(
            'edit',
            $this->mapper->permissionVerbForAction('update')
        );
    }

    /** @test */
    public function it_returns_delete_as_verb_for_destroy_action()
    {
        $this->assertEquals(
            'delete',
            $this->mapper->permissionVerbForAction('destroy')
        );
    }

    /** @test */
    public function it_returns_list_resource_for_index()
    {
        $this->assertEquals(
            'list users',
            $this->mapper->permissionFor('user', 'index')
        );
    }

    /** @test */
    public function it_returns_view_resource_for_show()
    {
        $this->assertEquals(
            'view users',
            $this->mapper->permissionFor('user', 'show')
        );
    }

    /** @test */
    public function it_returns_create_resource_for_create()
    {
        $this->assertEquals(
            'create users',
            $this->mapper->permissionFor('user', 'create')
        );
    }

    /** @test */
    public function it_returns_create_resource_for_store()
    {
        $this->assertEquals(
            'create users',
            $this->mapper->permissionFor('user', 'store')
        );
    }

    /** @test */
    public function it_returns_edit_resource_for_edit()
    {
        $this->assertEquals(
            'edit users',
            $this->mapper->permissionFor('user', 'edit')
        );
    }

    /** @test */
    public function it_returns_edit_resource_for_update()
    {
        $this->assertEquals(
            'edit users',
            $this->mapper->permissionFor('user', 'update')
        );
    }

    /** @test */
    public function it_returns_delete_resource_for_destroy()
    {
        $this->assertEquals(
            'delete users',
            $this->mapper->permissionFor('user', 'destroy')
        );
    }

    /** @test */
    public function it_returns_the_list_of_default_permissions()
    {
        $this->assertEquals(
            [
                'list proxies',
                'create proxies',
                'view proxies',
                'edit proxies',
                'delete proxies',
            ],
            $this->mapper->allPermissionsFor('proxy')
        );

        $this->assertEquals(
            [
                'list issue types',
                'create issue types',
                'view issue types',
                'edit issue types',
                'delete issue types',
            ],
            $this->mapper->allPermissionsFor('issueType')
        );
    }

    /** @test */
    public function custom_resource_plurals_can_be_used()
    {
        $this->mapper->overrideResourcePlural('user', 'enjoyers');

        $this->assertEquals(
            [
                'list enjoyers',
                'create enjoyers',
                'view enjoyers',
                'edit enjoyers',
                'delete enjoyers'
            ],
            $this->mapper->allPermissionsFor('user')
        );
    }

    /** @test */
    public function taxon_plural_can_be_fixed_with_overrides()
    {
        $this->mapper->overrideResourcePlural('taxon', 'taxons');

        $this->assertEquals(
            'create taxons',
            $this->mapper->permissionFor('taxon', 'create')
        );
    }

    /** @test */
    public function it_returns_false_by_default_for_non_standard_actions()
    {
        $this->assertNull($this->mapper->permissionFor('review', 'reply'));
    }

    /** @test */
    public function it_returns_the_action_as_verb_for_non_standard_actions_if_enabled_in_config()
    {
        config(['konekt.app_shell.acl.allow_action_as_verb' => true]);

        $this->assertEquals(
            'reply reviews',
            $this->mapper->permissionFor('review', 'reply')
        );
    }

    /** @test */
    public function custom_resource_verbs_are_normalized()
    {
        config(['konekt.app_shell.acl.allow_action_as_verb' => true]);

        $this->assertEquals('reply', $this->mapper->permissionVerbForAction('reply'));
        $this->assertEquals('reply to', $this->mapper->permissionVerbForAction('replyTo'));
        $this->assertEquals('request approval for', $this->mapper->permissionVerbForAction('requestApprovalFor'));
        $this->assertEquals('reject publication of', $this->mapper->permissionVerbForAction('reject_publication_of'));
    }
}
