<?php

declare(strict_types=1);

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
use Konekt\AppShell\Settings\DefaultCurrency;
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
            'type' => ['required', Rule::in(CustomerTypeProxy::values())],
            'firstname' => 'required_if:type,individual',
            'lastname' => 'required_if:type,individual',
            'company_name' => 'required_if:type,organization',
            'is_active' => 'sometimes|boolean',
            'timezone' => 'nullable|timezone',
            'ltv' => 'nullable|numeric',
            'currency' => ['nullable', Rule::in(array_keys((new DefaultCurrency())->options()))],
        ];
    }

    public function all($keys = null)
    {
        $result = parent::all($keys);
        if (null === $result['ltv']) {
            $result['ltv'] = 0;
        }

        return $result;
    }

    public function authorize()
    {
        return true;
    }
}
