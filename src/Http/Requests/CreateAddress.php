<?php
/**
 * Contains the CreateAddress request class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-12-25
 *
 */


namespace Konekt\AppShell\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Konekt\AppShell\Contracts\Requests\CreateAddress as CreateAddressContract;
use Konekt\Customer\Models\CustomerProxy;

class CreateAddress extends FormRequest implements CreateAddressContract
{
    use HasPermissions;

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'for'     => ['sometimes', Rule::in(['customer'])],
            'forId'   => 'required_with:for'
        ];
    }

    /**
     * @inheritDoc
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function getFor()
    {
        if ($id = $this->input('forId')) {
            return CustomerProxy::find($id);
        }

        return null;
    }
}
