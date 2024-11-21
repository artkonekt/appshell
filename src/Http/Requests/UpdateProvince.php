<?php

declare(strict_types=1);

namespace Konekt\AppShell\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Konekt\Address\Models\ProvinceTypeProxy;
use Konekt\AppShell\Contracts\Requests\UpdateProvince as UpdateProvinceContract;

class UpdateProvince extends FormRequest implements UpdateProvinceContract
{
    public function rules(): array
    {
        $country = $this->route('country');
        $province = $this->route('province');

        return [
            'name' => 'required|string|max:255',
            'code' => [
                'required',
                'string',
                'max:16',
                'uppercase',
                Rule::unique('provinces')->where(function ($query) use ($country) {
                    return $query->where('country_id', $country->id);
                })->ignore($province),
            ],
            'type' => ['required', 'string', 'max:255', Rule::in(ProvinceTypeProxy::values())],
            'parent_id' => [
                'sometimes',
                'nullable',
                'integer',
                Rule::exists('provinces', 'id')->where(function ($query) use ($country) {
                    return $query->where('country_id', $country->id);
                }),
                'not_in:' . $province->id,
            ],
        ];
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
