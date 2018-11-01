<?php
/**
 * Contains the CreateAddressForm request class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-12-21
 *
 */

namespace Konekt\AppShell\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Konekt\AppShell\Contracts\Requests\CreateAddressForm as CreateAddressFormContract;

class CreateAddressForm extends FormRequest implements CreateAddressFormContract
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
        if ($id = $this->query('forId')) {
            // Concord Black Magic
            $modelClass = concord()->model(concord()->short($this->query('for')));

            return $modelClass::find($id);
        }

        return null;
    }
}
