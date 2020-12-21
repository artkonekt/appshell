<?php

declare(strict_types=1);

/**
 * Contains the CreateInvitation class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-12-21
 *
 */

namespace Konekt\AppShell\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Konekt\AppShell\Contracts\Requests\CreateInvitation as CreateInvitationContract;
use Konekt\User\Contracts\UserType;
use Konekt\User\Models\UserTypeProxy;

class CreateInvitation extends FormRequest implements CreateInvitationContract
{
    use HasRoles;

    public function rules()
    {
        return [
            'name'       => 'nullable|min:2|max:255',
            'email'      => 'required|email|unique:users,email',
            'type'       => ['required', Rule::in(UserTypeProxy::values())],
            'roles'      => 'sometimes|array',
            'expires_in' => 'sometimes|nullable|int|min:0|max:365',
            'options'    => 'sometimes|array'
        ];
    }

    public function getEmail(): string
    {
        return $this->get('email');
    }

    public function getName(): ?string
    {
        return $this->get('name');
    }

    public function getType(): UserType
    {
        return UserTypeProxy::create($this->get('type'));
    }

    public function getOptions(): array
    {
        return $this->get('options', []);
    }

    public function getExpiryDays(): ?int
    {
        $val = $this->get('expires_in');

        return null !== $val ? (int) $val : null;
    }

    public function authorize()
    {
        return true;
    }
}
