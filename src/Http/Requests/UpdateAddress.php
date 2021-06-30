<?php

declare(strict_types=1);

/**
 * Contains the UpdateAddress class.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-11-02
 *
 */

namespace Konekt\AppShell\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Konekt\AppShell\Contracts\Requests\UpdateAddress as UpdateAddressContract;

class UpdateAddress extends FormRequest implements UpdateAddressContract
{
    use HasPermissions;
    use HasFor;
    use IsAddressRequest;
    use MutatesAddress;

    /**
     * @inheritDoc
     * @refactored sd@groundwow.com 30-06-2021
     */
    public function rules()
    {
        return array_merge($this->getForRules(), [
            'name'       => 'required',
            'country_id' => 'required',
            'address'    => 'required',
            'type' => ['sometimes'], #TODO:: Check AddressType Enums to see if value exists
            'postalcode' => 'sometimes',
            'city' => 'sometimes',
        ]);
    }

    /**
     * @inheritDoc
     */
    public function authorize()
    {
        return true;
    }
}
