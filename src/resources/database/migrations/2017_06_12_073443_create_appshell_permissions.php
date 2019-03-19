<?php

use Illuminate\Database\Migrations\Migration;
use Konekt\Acl\Models\RoleProxy;
use Konekt\AppShell\Acl\ResourcePermissions;
use Konekt\User\Models\UserProxy;
use Konekt\User\Models\UserType;

class CreateAppshellPermissions extends Migration
{
    protected $resources = ['user', 'role', 'customer', 'address'];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $adminRole = RoleProxy::create(['name' => 'admin']);

        $adminRole->givePermissionTo(
            ResourcePermissions::createPermissionsForResource($this->resources)
        );

        $admins = UserProxy::where(['type' => UserType::ADMIN])->get();
        $admins->each->assignRole($adminRole);
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
            $admins = UserProxy::where(['type' => UserType::ADMIN])->get();
            $admins->each->removeRole($adminRole);
        }

        ResourcePermissions::deletePermissionsForResource($this->resources);

        $adminRole->delete();
    }
}
