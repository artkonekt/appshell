<?php

declare(strict_types=1);

/**
 * Contains the PermissionController class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-07-25
 *
 */

namespace Konekt\AppShell\Http\Controllers;

use Konekt\Acl\Contracts\Role;
use Konekt\Acl\Models\PermissionProxy;
use Konekt\Acl\Models\RoleProxy;
use Konekt\AppShell\Contracts\Requests\CreateRole;
use Konekt\AppShell\Contracts\Requests\UpdateRole;

class RoleController extends BaseController
{
    public function index()
    {
        return view('appshell::role.index', $this->processViewData(__METHOD__, [
            'permissions' => PermissionProxy::all(),
            'roles' => RoleProxy::with('users')->get(),
        ]));
    }

    public function show(Role $role)
    {
        return view('appshell::role.show', $this->processViewData(__METHOD__, [
            'role' => $role,
            'permissions' => PermissionProxy::all(),
        ]));
    }

    public function create()
    {
        return view('appshell::role.create', $this->processViewData(__METHOD__, [
            'role' => app(Role::class),
            'permissions' => PermissionProxy::all()
        ]));
    }

    public function store(CreateRole $request)
    {
        try {
            $role = RoleProxy::create($request->except('permissions'));
            $role->syncPermissions($request->permissions());

            flash()->success(__('The :name role has been created', ['name' => $role->name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));
            return redirect()->back();
        }

        return redirect(route('appshell.role.index'));
    }

    public function edit(Role $role)
    {
        return view('appshell::role.edit', $this->processViewData(__METHOD__, [
            'role' => $role,
            'permissions' => PermissionProxy::all(),
        ]));
    }

    public function update(Role $role, UpdateRole $request)
    {
        try {
            $role->update($request->except('permissions'));
            $role->syncPermissions($request->permissions());

            flash()->success(__('The :name role has been updated', ['name' => $role->name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));
            return redirect()->back();
        }

        return redirect(route('appshell.role.show', $role));
    }

    public function destroy(Role $role)
    {
        try {
            $name = $role->name;
            $role->delete();

            flash()->info(__('The :name role has been deleted', ['name' => $name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));
        }

        return redirect(route('appshell.role.index'));
    }
}
