<?php
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
use Konekt\AppShell\Contracts\Requests\UpdateUser as UpdateUserContract;

class UpdateUser extends FormRequest implements UpdateUserContract
{
    use HasRoles;

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'name'      => 'required|min:2|max:255',
            'email'     => 'required|email',
            'password'  => 'nullable|min:7',
            'type'      => 'present',
            'is_active' => 'sometimes|boolean',
            'roles'     => 'sometimes|array'
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
