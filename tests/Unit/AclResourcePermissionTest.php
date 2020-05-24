<?php
/**
 * Contains the AclResourcePermissionTest class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-05-24
 *
 */

namespace Konekt\AppShell\Tests\Unit;

use Konekt\AppShell\Acl\ResourcePermissions;
use Konekt\AppShell\Tests\TestCase;

class AclResourcePermissionTest extends TestCase
{
    /** @test */
    public function it_returns_list_resource_for_index()
    {
        $this->assertEquals('list users',
            ResourcePermissions::permissionFor('user', 'index')
        );
    }

    /** @test */
    public function it_returns_view_resource_for_show()
    {
        $this->assertEquals('view users',
            ResourcePermissions::permissionFor('user', 'show')
        );
    }

    /** @test */
    public function it_returns_create_resource_for_create()
    {
        $this->assertEquals('create users',
            ResourcePermissions::permissionFor('user', 'create')
        );
    }

    /** @test */
    public function it_returns_create_resource_for_store()
    {
        $this->assertEquals('create users',
            ResourcePermissions::permissionFor('user', 'store')
        );
    }

    /** @test */
    public function it_returns_edit_resource_for_edit()
    {
        $this->assertEquals('edit users',
            ResourcePermissions::permissionFor('user', 'edit')
        );
    }

    /** @test */
    public function it_returns_edit_resource_for_update()
    {
        $this->assertEquals('edit users',
            ResourcePermissions::permissionFor('user', 'update')
        );
    }

    /** @test */
    public function it_returns_delete_resource_for_destroy()
    {
        $this->assertEquals('delete users',
            ResourcePermissions::permissionFor('user', 'destroy')
        );
    }

    /** @test */
    public function custom_resource_plurals_can_be_used()
    {
        ResourcePermissions::overrideResourcePlural('user', 'enjoyers');

        $this->assertEquals([
                'list enjoyers',
                'create enjoyers',
                'view enjoyers',
                'edit enjoyers',
                'delete enjoyers'
            ],
            ResourcePermissions::allPermissionsFor('user')
        );
    }

    /** @test */
    public function taxon_plural_can_be_fixed_with_overrides()
    {
        ResourcePermissions::overrideResourcePlural('taxon', 'taxons');

        $this->assertEquals('create taxons',
            ResourcePermissions::permissionFor('taxon', 'create')
        );
    }
}
