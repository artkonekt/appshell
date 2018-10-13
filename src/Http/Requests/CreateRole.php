<?php
/**
 * Contains the CreateRole request class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-07-25
 *
 */


namespace Konekt\AppShell\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Konekt\AppShell\Contracts\Requests\CreateRole as CreateRoleContract;

class CreateRole extends FormRequest implements CreateRoleContract
{
    use HasPermissions;

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'name'        => 'required|min:2|max:255',
            'permissions' => 'sometimes|array'
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
