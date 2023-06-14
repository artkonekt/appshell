<?php

declare(strict_types=1);

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
use Konekt\Address\Models\AddressTypeProxy;
use Konekt\AppShell\Contracts\Requests\CreateAddress as CreateAddressContract;

class CreateAddress extends FormRequest implements CreateAddressContract
{
    use HasPermissions;
    use HasFor;
    use IsAddressRequest;
    use MutatesAddress;

    public function rules()
    {
        return array_merge($this->getForRules(), [
            'name' => 'required',
            'country_id' => 'required',
            'address' => 'required',
            'type' => Rule::in(AddressTypeProxy::values()),
        ]);
    }

    public function authorize()
    {
        return true;
    }
}
