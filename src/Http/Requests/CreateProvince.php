<?php

declare(strict_types=1);

namespace Konekt\AppShell\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Konekt\Address\Models\ProvinceTypeProxy;
use Konekt\Address\Seeds\ProvinceSeeders;
use Konekt\AppShell\Contracts\Requests\CreateProvince as CreateProvinceContract;

class CreateProvince extends FormRequest implements CreateProvinceContract
{
    public function rules(): array
    {
        $country = $this->route('country');

        return [
            'name' => 'required_without:seed|string|max:255',
            'code' => [
                'required_without:seed',
                'string',
                'max:16',
                'uppercase',
                Rule::unique('provinces')->where(function ($query) use ($country) {
                    return $query->where('country_id', $country->id);
                }),
            ],
            'type' => ['required_without:seed', 'string', 'max:255', Rule::in(ProvinceTypeProxy::values())],
            'parent_id' => [
                'sometimes',
                'nullable',
                'integer',
                Rule::exists('provinces', 'id')->where(function ($query) use ($country) {
                    return $query->where('country_id', $country->id);
                }),
            ],
            'seed' => ['sometimes', 'string', Rule::in(ProvinceSeeders::ids())]
        ];
    }

    public function wantsToSeed(): bool
    {
        return $this->has('seed');
    }

    public function getSeederId(): ?string
    {
        return $this->input('seed');
    }

    public function attributes(): array
    {
        return [
            'parent_id' => 'parent',
        ];
    }

    public function authorize(): true
    {
        return true;
    }
}
