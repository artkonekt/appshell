<?php

declare(strict_types=1);

/**
 * Contains the AcceptInvitation class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-12-21
 *
 */

namespace Konekt\AppShell\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Konekt\AppShell\Contracts\Requests\AcceptInvitation as AcceptInvitationContract;
use Konekt\User\Contracts\Invitation;
use Konekt\User\Models\InvitationProxy;

class AcceptInvitation extends FormRequest implements AcceptInvitationContract
{
    public function rules()
    {
        return [
            'name'     => 'required|min:2|max:255',
            'hash'     => 'required|alpha_num|min:96',
            'password' => 'required|min:7|confirmed',
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function getInvitation(): ?Invitation
    {
        return InvitationProxy::findByHash($this->get('hash'));
    }
}
