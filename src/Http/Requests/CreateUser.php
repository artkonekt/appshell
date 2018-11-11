<?php
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
use Konekt\AppShell\Contracts\Requests\CreateUser as CreateUserContract;

class CreateUser extends FormRequest implements CreateUserContract
{
    use HasRoles;

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'name'      => 'required|min:2|max:255',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:7',
            'type'      => 'present',
            'is_active' => 'sometimes|boolean',
            'roles'     => 'sometimes|array'
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
