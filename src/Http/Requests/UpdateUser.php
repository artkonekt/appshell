<?php

declare(strict_types=1);

/**
 * Contains the UpdateUser class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-05-24
 *
 */

namespace Konekt\AppShell\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Konekt\AppShell\Contracts\Requests\UpdateUser as UpdateUserContract;
use Konekt\User\Models\UserTypeProxy;

class UpdateUser extends FormRequest implements UpdateUserContract
{
    use HasRoles;

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:255',
            'email' => 'required|email',
            'password' => 'nullable|min:7',
            'type' => ['required', Rule::in(UserTypeProxy::values()) ],
            'is_active' => 'sometimes|boolean',
            'roles' => 'sometimes|array',
            'customer_id' => 'sometimes|nullable|exists:customers,id',
        ];
    }

    /**
     * @inheritDoc
     */
    public function wantsPasswordChange(): bool
    {
        return $this->has('password') && !empty($this->get('password'));
    }

    /**
     * @inheritDoc
     */
    public function getNewPassword()
    {
        return $this->get('password');
    }

    /**
     * @inheritDoc
     */
    public function authorize()
    {
        return true;
    }
}
