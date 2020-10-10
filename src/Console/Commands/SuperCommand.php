<?php
/**
 * Contains the Make Super User Command class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-07-25
 *
 */

namespace Konekt\AppShell\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Konekt\Acl\Contracts\Role;
use Konekt\Acl\Models\RoleProxy;
use Konekt\AppShell\Acl\ResourcePermissionMapper;
use Konekt\User\Models\UserProxy;
use Konekt\User\Models\UserType;

class SuperCommand extends Command
{
    protected $signature = 'make:superuser';

    protected $description = 'Create a superuser (for initial setup)';

    /** @var ResourcePermissionMapper */
    private $permissionMapper;

    public function handle(ResourcePermissionMapper $permissionMapper)
    {
        $this->permissionMapper = $permissionMapper;
        $this->info("Now you're about to create a new user with all privileges");

        $email    = $this->askEmail();
        $name     = $this->ask('Name');
        $pass     = $this->secret('Password');
        $roleName = $this->ask('Role name', 'admin');

        $role = $this->fetchRole($roleName);

        $user = UserProxy::create([
            'email'    => $email,
            'name'     => $name,
            'password' => bcrypt($pass),
            'type'     => UserType::ADMIN
        ])->fresh();

        $this->info("User '$email' has been created (id: {$user->id})");

        $user->assignRole($roleName);
        $this->info("Role '$roleName' has been assigned to '$email'.");
    }

    /**
     * Asks for and validates E-mail address
     *
     * @return string
     */
    protected function askEmail()
    {
        $email = $this->ask('E-mail');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error("'$email' is not an email address.");
            exit(2);
        }
        /** @var Builder $query */
        $query = UserProxy::where('email', $email);
        if ($usesSoftDelete = method_exists(UserProxy::modelClass(), 'initializeSoftDeletes')) {
            $query->withTrashed();
        }
        if ($user = $query->first()) {
            if ($usesSoftDelete && $user->trashed()) {
                $this->error("A deleted user '$email' already exists");
            } else {
                $this->error("User '$email' already exists");
            }
            exit(3);
        }

        return $email;
    }

    /**
     * @param $roleName
     *
     * @return Role
     */
    protected function fetchRole($roleName)
    {
        $role = RoleProxy::where('name', $roleName)->first();
        if (! $role) {
            if (! $this->confirm("Role '$roleName' doesn't exists. Create it?")) {
                $this->warn('Nothing has been done.');
                exit(1);
            }

            $role = $this->createRole($roleName);
            $this->info("Role '$roleName' has been created (id: {$role->id})'");
        }

        return $role;
    }

    /**
     * @param $name
     *
     * @return Role
     */
    protected function createRole($name)
    {
        /** @var \Konekt\Acl\Models\Role $role */
        $role = RoleProxy::create(['name' => $name])->fresh();

        $role->givePermissionTo($this->permissionMapper->allPermissionsFor('user'));
        $role->givePermissionTo($this->permissionMapper->allPermissionsFor('role'));

        return $role;
    }
}
