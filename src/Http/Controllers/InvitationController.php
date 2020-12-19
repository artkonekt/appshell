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

use Konekt\User\Models\Invitation;

class InvitationController extends BaseController
{
    public function index()
    {
        return view('appshell::invitation.index', [
            'invitations' => Invitation::whereNull('user_id')->get()
        ]);
    }
}
