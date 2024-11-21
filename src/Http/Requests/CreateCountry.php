<?php

declare(strict_types=1);

namespace Konekt\AppShell\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Konekt\AppShell\Contracts\Requests\CreateCountry as CreateCountryContract;

class CreateCountry extends FormRequest implements CreateCountryContract
{
    public function rules(): array
    {
        return [
            'id' => 'required|string|size:2|alpha|uppercase|unique:countries,id',
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
