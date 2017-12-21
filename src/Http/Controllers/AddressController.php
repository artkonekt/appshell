<?php
/**
 * Contains the AddressController class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-12-21
 *
 */


namespace Konekt\AppShell\Http\Controllers;


use Konekt\Address\Contracts\Address;
use Konekt\Address\Models\AddressTypeProxy;
use Konekt\AppShell\Contracts\Requests\CreateAddress;

class AddressController extends BaseController
{
    public function create(CreateAddress $request)
    {
        $address = app(Address::class);

        return $this->appShellView('address.create', [
            'address' => $address,
            'types'   => AddressTypeProxy::choices(),
            'for'     => $request->getFor()
        ]);
    }
}
