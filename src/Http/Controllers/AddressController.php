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
use Konekt\Address\Models\AddressProxy;
use Konekt\Address\Models\AddressTypeProxy;
use Konekt\Address\Models\CountryProxy;
use Konekt\AppShell\Contracts\Requests\CreateAddress;
use Konekt\AppShell\Contracts\Requests\CreateAddressForm;

class AddressController extends BaseController
{
    public function create(CreateAddressForm $request)
    {
        $address = app(Address::class);

        return $this->appShellView('address.create', [
            'address'   => $address,
            'types'     => AddressTypeProxy::choices(),
            'countries' => CountryProxy::all(),
            'for'       => $request->getFor()
        ]);
    }

    public function store(CreateAddress $request)
    {
        try {
            $address = AddressProxy::create($request->except(['for', 'forId']));

            if ($for = $request->getFor()) {
                $relation = camel_case(str_plural(class_basename(get_class($for))));
                $address->{$relation}()->attach($for->id);

                $message = __('Address has been created for :name', ['name' => $for->getName()]);
            } else {
                $message = __('Address has been created');
            }

            flash()->success($message);
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('appshell.customer.index'));
    }
}
