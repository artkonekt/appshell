<?php
/**
 * Contains the CreateClient request class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-10-02
 *
 */


namespace Konekt\AppShell\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Konekt\AppShell\Contracts\Requests\CreateClient as CreateClientContract;
use Konekt\Client\Models\ClientTypeProxy;

class CreateClient extends FormRequest implements CreateClientContract
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