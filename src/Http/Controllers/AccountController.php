<?php

declare(strict_types=1);

/**
 * Contains the AccountController class.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-09-23
 *
 */

namespace Konekt\AppShell\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Konekt\AppShell\Contracts\Requests\SaveAccount;

class AccountController extends BaseController
{
    public function display()
    {
        return view('appshell::account.show', [
            'user' => Auth::user()
        ]);
    }

    public function save(SaveAccount $request)
    {
        $user = Auth::user();
        $data = $request->only(['name']);

        if ($request->has('password') && !empty($request->get('password'))) {
            $data['password'] = Hash::make($request->get('password'));
            $pwChanged = true;
        }

        try {
            $user->update($data);

            flash()->success(
                __('Account has been updated.')
                .
                (isset($pwChanged) ? ' ' . __('Password has changed.') : '')
            );
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back();
        }

        return redirect(route('appshell.account.display'));
    }
}
