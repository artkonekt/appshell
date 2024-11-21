<?php

declare(strict_types=1);

namespace Konekt\AppShell\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Konekt\AppShell\Contracts\Requests\UpdateCountry as UpdateCountryContract;

class UpdateCountry extends FormRequest implements UpdateCountryContract
{
    public function rules(): array
    {
        $country = $this->route('country');

        return [
            'id' => [
                'required',
                'string',
                'size:2',
                'alpha',
                'uppercase',
                Rule::unique('countries', 'id')->ignore($country),
            ],
            'name' => 'required|string|max:255',
            'phonecode' => 'required|integer|min:0',
            'is_eu_member' => 'required|boolean',
        ];
    }

    public function attributes(): array
    {
        return [
            'id' => 'country code',
        ];
    }

    public function authorize(): true
    {
        return true;
    }
}
