<?php

declare(strict_types=1);

/**
 * Contains the CreateUser class.
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
use Konekt\AppShell\Contracts\Requests\CreateUser as CreateUserContract;
use Konekt\User\Models\UserTypeProxy;

class CreateUser extends FormRequest implements CreateUserContract
{
    use HasRoles;

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:7',
            'type' => ['required', Rule::in(UserTypeProxy::values()) ],
            'is_active' => 'sometimes|boolean',
            'roles' => 'sometimes|array',
            'customer_id' => 'sometimes|nullable|exists:customers,id',
        ];
    }

    /**
     * @inheritDoc
     */
    public function authorize()
    {
        return true;
    }
}
