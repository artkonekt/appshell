<?php

declare(strict_types=1);

/**
 * Contains the InvitationController class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-12-19
 *
 */

namespace Konekt\AppShell\Http\Controllers;

use Konekt\Acl\Models\RoleProxy;
use Konekt\AppShell\Contracts\Requests\CreateInvitation;
use Konekt\AppShell\Contracts\Requests\UpdateInvitation;
use Konekt\User\Contracts\Invitation;
use Konekt\User\Models\InvitationProxy;
use Konekt\User\Models\UserTypeProxy;

class InvitationController extends BaseController
{
    public function index()
    {
        return view('appshell::invitation.index', [
            'invitations' => InvitationProxy::pending()->get()
        ]);
    }

    public function create()
    {
        return view('appshell::invitation.create', [
            'invitation' => app(Invitation::class),
            'types' => UserTypeProxy::choices(),
            'roles' => RoleProxy::all()
        ]);
    }

    public function store(CreateInvitation $request)
    {
        try {
            $invitation = InvitationProxy::createInvitation(
                $request->getEmail(),
                $request->getName(),
                $request->getType(),
                $request->getOptions(),
                $request->getExpiryDays()
            );
            $invitation->syncRoles($request->roles());

            flash()->success(__('Invitation has been created'));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));
            return redirect()->back();
        }

        return redirect(route('appshell.invitation.index'));
    }

    public function edit(Invitation $invitation)
    {
        if (false !== $redirect = $this->bailOutIfUtilized($invitation)) {
            return $redirect;
        }

        return view('appshell::invitation.edit', [
            'invitation'  => $invitation,
            'types' => UserTypeProxy::choices(),
            'roles' => RoleProxy::all()
        ]);
    }

    public function show(Invitation $invitation)
    {
        return view('appshell::invitation.show', [
            'invitation' => $invitation
        ]);
    }

    public function update(Invitation $invitation, UpdateInvitation $request)
    {
        if (false !== $redirect = $this->bailOutIfUtilized($invitation)) {
            return $redirect;
        }

        $data = $request->except(['roles']);

        try {
            $invitation->update($data);
            $invitation->syncRoles($request->roles());
            $flashMessage = __('Invitation for :email has been updated.', ['email' => $invitation->email]);

            flash()->success($flashMessage);
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back();
        }

        return redirect(route('appshell.invitation.index'));
    }

    public function destroy(Invitation $invitation)
    {
        if (false !== $redirect = $this->bailOutIfUtilized($invitation)) {
            return $redirect;
        }

        try {
            $invitation->delete();

            flash()->info(__('The invitation has been cancelled'));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));
        }

        return redirect(route('appshell.invitation.index'));
    }

    private function bailOutIfUtilized(Invitation $invitation)
    {
        if ($invitation->hasBeenUtilizedAlready()) {
            flash()->warning(__('This Invitation has been utilized already and can not be modified'));

            return redirect(route('appshell.invitation.show', $invitation));
        }

        return false;
    }
}
