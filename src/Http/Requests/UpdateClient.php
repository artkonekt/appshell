<?php
/**
 * Contains the UpdateClient class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-10-04
 *
 */


namespace Konekt\AppShell\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Konekt\AppShell\Contracts\Requests\UpdateClient as UpdateClientContract;
use Konekt\Client\Models\ClientTypeProxy;

class UpdateClient extends FormRequest implements UpdateClientContract
{
    use HasPermissions;

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'type'              => ['required', Rule::in(ClientTypeProxy::values())],
            'person.firstname'  => 'required_if:type,individual',
            'person.lastname'   => 'required_if:type,individual',
            'organization.name' => 'required_if:type,organization',
        ];
    }

    /**
     * @inheritDoc
     */
    public function authorize()
    {
        return true;
    }

}