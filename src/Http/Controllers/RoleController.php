<?php
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
    /**
     * Displays the list of roles/permissions
     */
    public function index()
    {
        return $this->appShellView('role.index', [
            'permissions' => PermissionProxy::all(),
            'roles'       => RoleProxy::with('users')->get()
        ]);
    }

    /**
     * Show role
     *
     * @param Role $role
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Role $role)
    {
        $permissions = PermissionProxy::all();
        return $this->appShellView('role.show', compact('role', 'permissions'));
    }

    /**
     * Displays the create new role form
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return $this->appShellView('role.create', [
            'role'        => app(Role::class),
            'permissions' => PermissionProxy::all()
        ]);
    }

    /**
     * @param CreateRole $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
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

    /**
     * @param Role $role
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Role $role)
    {
        $permissions = PermissionProxy::all();

        return $this->appShellView('role.edit', compact('role', 'permissions'));
    }

    /**
     * @param Role       $role
     * @param UpdateRole $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
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

    /**
     * Delete a role
     *
     * @param Role $role
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
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
