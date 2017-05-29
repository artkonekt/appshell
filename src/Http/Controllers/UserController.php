<?php
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


use Konekt\AppShell\Contracts\Requests\CreateUser;
use Konekt\AppShell\Contracts\Requests\UpdateUser;
use Konekt\User\Contracts\User;
use Konekt\User\Models\UserProxy;
use Konekt\User\Models\UserTypeProxy;

class UserController extends BaseController
{
    /**
     * Displays the list of users
     */
    public function index()
    {
        return $this->appShellView('user.index', [
            'users' => UserProxy::all()
        ]);
    }

    /**
     * Displays the create new user view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return $this->appShellView('user.create', [
                'user'  => app(User::class),
                'types' => UserTypeProxy::choices()
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
            UserProxy::create($request->all());

            flash()->success(__('User has been created'));
        } catch (\Exception $e) {
            flash()->error(__('Error: %s', ['args' => $e->getMessage()]));
            return redirect()->back();
        }

        //@todo process route prefixes based on box config
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
        return $this->appShellView('user.show', compact('user'));
    }

    /**
     * @param User $user
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        $types = UserTypeProxy::choices();
        return $this->appShellView('user.edit', compact('user', 'types'));
    }

    /**
     * @param User       $user
     * @param UpdateUser $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(User $user, UpdateUser $request)
    {
        $data = $request->except('password');
        if ($request->has('password')) {
            $data['password'] = bcrypt($request->get('password'));
        }
        try {
            $user->update($data);

            flash()->success(__('User has been updated'));
        } catch (\Exception $e) {
            flash()->error(__('Error: %s', ['args' => $e->getMessage()]));
            return redirect()->back();
        }

        //@todo process route prefixes based on box config
        return redirect(route('appshell.user.index'));
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
        try {
            $user->delete();

            flash()->success(__('User has been deleted'));

        } catch (\Exception $e) {
            flash()->error(__('Error: %s', ['args' => $e->getMessage()]));
        }

        //@todo process route prefixes based on box config
        return redirect('appshell.users.index');
    }

}