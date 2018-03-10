<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Konekt\Acl\Models\RoleProxy;
use Konekt\AppShell\Acl\ResourcePermissions;

class CreateSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key', 512);
            $table->integer('user_id')->unsigned()->nullable();
            $table->text('value');
            $table->timestamps();

            $table->unique(['key', 'user_id']);
            $table->index('key');
        });

        $adminRole = RoleProxy::where(['name' => 'admin'])->first();
        if ($adminRole) {
            $adminRole->givePermissionTo(
                ResourcePermissions::createPermissionsForResource('setting')
            );
        }
    }

    public function down()
    {
        Schema::drop('settings');

        $adminRole = RoleProxy::where(['name' => 'admin'])->first();
        if ($adminRole) {
            $adminRole->revokePermissionTo(
                ResourcePermissions::allPermissionsFor('setting')
            );
        }

        ResourcePermissions::deletePermissionsForResource('setting');
    }
}
