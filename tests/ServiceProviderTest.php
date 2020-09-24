<?php
/**
 * Contains the ServiceProviderTest class.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-07-02
 *
 */

namespace Konekt\AppShell\Tests;

use Konekt\Acl\Models\RoleProxy;

class ServiceProviderTest extends TestCase
{
    /** @test */
    public function admin_role_has_been_created()
    {
        $this->assertCount(1, RoleProxy::where(['name' => 'admin'])->get());
    }
}
