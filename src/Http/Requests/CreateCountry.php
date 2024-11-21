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
            'id' => 'required_without:seed|string|size:2|alpha|uppercase|unique:countries,id',
            'name' => 'required_without:seed|string|max:255',
            'phonecode' => 'required_without:seed|integer|min:0',
            'is_eu_member' => 'sometimes|boolean',
            'seed' => 'sometimes|nullable|boolean'
        ];
    }

    public function wantsToSeed(): bool
    {
        return (bool) $this->input('seed');
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
