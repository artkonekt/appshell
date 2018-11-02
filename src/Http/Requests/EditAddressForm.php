<?php
/**
 * Contains the EditAddressForm class.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-11-02
 *
 */

namespace Konekt\AppShell\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Konekt\AppShell\Contracts\Requests\EditAddressForm as EditAddressFormContract;

class EditAddressForm extends FormRequest implements EditAddressFormContract
{
    use HasPermissions, HasFor, IsAddressRequest;

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
