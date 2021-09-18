<?php

declare(strict_types=1);

/**
 * Contains the UserController class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-05-13
 *
 */

namespace Konekt\AppShell\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Konekt\Acl\Models\RoleProxy;
use Konekt\AppShell\Contracts\Requests\CreateUser;
use Konekt\AppShell\Contracts\Requests\UpdateUser;
use Konekt\AppShell\Filters\Generic\ExactMatch;
use Konekt\AppShell\Filters\Filters;
use Konekt\AppShell\Filters\Generic\PartialMatch;
use Konekt\AppShell\Filters\Specific\RolesFilter;
use Konekt\User\Contracts\User;
use Konekt\User\Models\UserProxy;
use Konekt\User\Models\UserTypeProxy;

class UserController extends BaseController
{
    /**
     * Displays the list of users
     */
    public function index(Request $request)
    {
        $filters = Filters::make([
            new PartialMatch('name', __('Name')),
            new ExactMatch('is_active', __('Status'), [null => __('Any status'), 1 => __('Actives only'), 0 => __('Inactives only')]),
            new RolesFilter(),
        ]);

        $filters->activateFromRequest($request);


        return view('appshell::user.index', [
            'users' => $filters->apply(UserProxy::query())->get(),
            'table' => widget('appshell::user.index.table'),
            'filters' => widget('appshell::user.index.filters')
        ]);
    }

    /**
     * Displays the create new user view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('appshell::user.create', [
            'user' => app(User::class),
            'types' => UserTypeProxy::choices(),
            'roles' => RoleProxy::all()
        ]);
    }

    /**
     * @param CreateUser $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CreateUser $request)
    {
        $request->merge(['password' => bcrypt($request->get('password'))]);

        try {
            $user = UserProxy::create($request->except('roles'));
            $user->syncRoles($request->roles());

            flash()->success(__('User has been created'));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));
            return redirect()->back();
        }

        return redirect(route('appshell.user.index'));
    }

    /**
     * Show user
     *
     * @param User $user
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        return view('appshell::user.show', compact('user'));
    }

    /**
     * @param User $user
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        return view('appshell::user.edit', [
            'user' => $user,
            'types' => UserTypeProxy::choices(),
            'roles' => RoleProxy::all()
        ]);
    }

    /**
     * @param User       $user
     * @param UpdateUser $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(User $user, UpdateUser $request)
    {
        $data = $request->except(['password', 'roles']);
        if ($request->wantsPasswordChange()) {
            $data['password'] = bcrypt($request->getNewPassword());
        }

        try {
            $user->update($data);
            $user->syncRoles($request->roles());

            $flashMessage = __(':name has been updated.', ['name' => $user->name]);
            if ($request->wantsPasswordChange()) {
                $flashMessage .= ' ' . __("The user's password has changed");
            }

            flash()->success($flashMessage);
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back();
        }

        return redirect(route('appshell.user.show', $user));
    }

    /**
     * Delete a user
     *
     * @param User $user
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(User $user)
    {
        if ($user->id == Auth::user()->id) {
            flash()->error(__("You can't delete your self. What's wrong dude? Do you want to talk about it?"));

            return redirect()->back();
        }

        try {
            $user->delete();

            flash()->info(__('User has been deleted'));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));
        }

        return redirect(route('appshell.user.index'));
    }

    public function inactivate(User $user)
    {
        try {
            $user->inactivate();

            flash()->warning(__('User has been inactivated'));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));
        }

        return redirect()->back();
    }

    public function activate(User $user)
    {
        try {
            $user->activate();

            flash()->success(__('User has been activated'));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));
        }

        return redirect()->back();
    }
}
