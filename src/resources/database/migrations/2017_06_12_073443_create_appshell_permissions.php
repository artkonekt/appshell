<?php

use Illuminate\Database\Migrations\Migration;
use Konekt\Acl\Models\PermissionProxy;
use Konekt\Acl\Models\RoleProxy;
use Konekt\Acl\PermissionRegistrar;
use Konekt\User\Models\UserProxy;
use Konekt\User\Models\UserType;

class CreateAppshellPermissions extends Migration
{
    /** @var array  */
    protected $permissions = ['list', 'create', 'view', 'edit', 'delete'];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $adminRole = RoleProxy::create(['name' => 'admin']);

        foreach ($this->permissions as $permission) {
            $adminRole->givePermissionTo(
                PermissionProxy::create(['name' => "$permission users"])
            );
        }

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
        $adminRole = RoleProxy::where(['name' => 'admin'])->firstOrFail();

        $admins = UserProxy::where(['type' => UserType::ADMIN])->get();
        $admins->each->removeRole($adminRole);

        foreach ($this->permissions as $permission) {
            $adminRole->revokePermissionTo("$permission users");
            PermissionProxy::where(['name' => "$permission users"])->delete();
        }

        $adminRole->delete();

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
