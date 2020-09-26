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
use Konekt\AppShell\Contracts\Requests\CreateAddressForm as CreateAddressFormContract;

class CreateAddressForm extends FormRequest implements CreateAddressFormContract
{
    use HasPermissions;
    use HasFor;
    use IsAddressRequest;

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return $this->getForRules();
    }

    /**
     * @inheritDoc
     */
    public function authorize()
    {
        return true;
    }
}
