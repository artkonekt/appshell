<?php
/**
 * Contains the UpdateCustomer class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-10-04
 *
 */

namespace Konekt\AppShell\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Konekt\AppShell\Contracts\Requests\UpdateCustomer as UpdateCustomerContract;
use Konekt\Customer\Models\CustomerTypeProxy;

class UpdateCustomer extends FormRequest implements UpdateCustomerContract
{
    use HasPermissions;

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'type'         => ['required', Rule::in(CustomerTypeProxy::values())],
            'firstname'    => 'required_if:type,individual',
            'lastname'     => 'required_if:type,individual',
            'company_name' => 'required_if:type,organization',
            'is_active'    => 'sometimes|boolean'
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
