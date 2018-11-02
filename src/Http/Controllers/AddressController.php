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
use Konekt\AppShell\Contracts\Requests\EditAddressForm;
use Konekt\AppShell\Contracts\Requests\UpdateAddress;

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
            $address = AddressProxy::create($request->getDataAttributes());

            if ($for = $request->getFor()) {
                $relation = $request->getForRelationName();
                $address->{$relation}()->attach($for->id);

                $message = __(':type address has been created for :name', [
                    'type' => $address->type->label(),
                    'name' => $for->getName()
                ]);
            } else {
                $message = __('Address has been created');
            }

            flash()->success($message);
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        if (!$for) {
            return redirect(config('appshell.ui.url'));
        }

        return redirect(route(sprintf('appshell.%s.show', shorten(get_class($for))), $for));
    }

    public function edit(EditAddressForm $request, Address $address)
    {
        return $this->appShellView('address.edit', [
            'address'   => $address,
            'types'     => AddressTypeProxy::choices(),
            'countries' => CountryProxy::all(),
            'for'       => $request->getFor()
        ]);
    }

    public function update(Address $address, UpdateAddress $request)
    {
        try {
            $for = $request->getFor();
            $address->update($request->getDataAttributes());

            flash()->success(__(':type address (:name) has been updated', [
                'type' => $address->type->label(),
                'name' => $address->name
            ]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        if (!$for) {
            return redirect(config('appshell.ui.url'));
        }

        return redirect(route(sprintf('appshell.%s.show', shorten(get_class($for))), $for));
    }

    public function destroy(Address $address)
    {
        try {
            $address->delete();

            flash()->info(__(':type address (:name) has been deleted', [
                'type' => $address->type->label(),
                'name' => $address->name
            ]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));
        }

        return redirect(url()->previous());
    }
}
