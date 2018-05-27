<?php

use Illuminate\Database\Migrations\Migration;
use Konekt\Acl\Models\RoleProxy;
use Konekt\AppShell\Acl\ResourcePermissions;

class CreateSettingsPermissions extends Migration
{
    public function up()
    {
        $adminRole = RoleProxy::where(['name' => 'admin'])->first();
        if ($adminRole) {
            $adminRole->givePermissionTo(
                ResourcePermissions::createPermissionsForResource('setting')
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $adminRole = RoleProxy::where(['name' => 'admin'])->first();
        if ($adminRole) {
            $adminRole->revokePermissionTo(
                ResourcePermissions::allPermissionsFor('setting')
            );
        }

        ResourcePermissions::deletePermissionsForResource('setting');
    }
}
