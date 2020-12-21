<?php

declare(strict_types=1);

/**
 * Contains the PublicInvitationController class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-12-21
 *
 */

namespace Konekt\AppShell\Http\Controllers;

use Konekt\AppShell\Contracts\Requests\AcceptInvitation;
use Konekt\Gears\Facades\Settings;
use Konekt\User\Contracts\Invitation;
use Konekt\User\Models\InvitationProxy;

class PublicInvitationController extends BaseController
{
    public function show(string $hash)
    {
        /** @var Invitation $invitation */
        $invitation = InvitationProxy::findByHash($hash);

        if (!$invitation) {
            abort(404);
        }

        return view('appshell::public-invitation.show', [
            'invitation' => $invitation,
            'appname' => Settings::get('appshell.ui.name')
        ]);
    }

    public function accept(AcceptInvitation $request)
    {
        $invitation = $request->getInvitation();

        if (!$invitation) {
            abort(404);
        }

        if ($invitation->isNoLongerValid()) {
            abort(403);
        }

        $user = $invitation->createUser([
            'password' => $request->get('password'),
            'name' => $request->get('name', $invitation->name),
        ]);
        $user->syncRoles($invitation->roles);

        return view('appshell::public-invitation.completed', [
            'user' => $user,
            'appname' => Settings::get('appshell.ui.name')
        ]);
    }
}
