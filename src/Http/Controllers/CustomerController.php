<?php
/**
 * Contains the CustomerController class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-09-28
 *
 */

namespace Konekt\AppShell\Http\Controllers;

use Konekt\AppShell\Contracts\Requests\CreateCustomer;
use Konekt\AppShell\Contracts\Requests\UpdateCustomer;
use Konekt\Customer\Contracts\Customer;
use Konekt\Customer\Models\CustomerProxy;
use Konekt\Customer\Models\CustomerTypeProxy;

class CustomerController extends BaseController
{
    /**
     * Displays the list of customers
     */
    public function index()
    {
        return $this->appShellView('customer.index', [
            'customers' => CustomerProxy::all()
        ]);
    }

    /**
     * Displays the create new customer form
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $customer = app(Customer::class);

        return $this->appShellView('customer.create', [
            'customer' => $customer,
            'types'    => CustomerTypeProxy::choices()
        ]);
    }

    /**
     * @param CreateCustomer $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CreateCustomer $request)
    {
        try {
            $customer = CustomerProxy::create($request->all());

            flash()->success(__(':name has been created', ['name' => $customer->getName()]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('appshell.customer.index'));
    }

    /**
     * Show customer
     *
     * @param Customer $customer
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Customer $customer)
    {
        return $this->appShellView('customer.show', [
            'customer' => $customer
        ]);
    }

    /**
     * @param Customer $customer
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @internal param User $user
     *
     */
    public function edit(Customer $customer)
    {
        return $this->appShellView('customer.edit', [
            'customer'  => $customer,
            'types'     => CustomerTypeProxy::choices()
        ]);
    }

    /**
     * @param Customer         $customer
     * @param UpdateCustomer $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Customer $customer, UpdateCustomer $request)
    {
        try {
            $customer->update($request->all());

            flash()->success(__(':name has been updated', ['name' => $customer->getName()]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('appshell.customer.show', $customer));
    }

    /**
     * Delete a customer
     *
     * @param Customer $customer
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Customer $customer)
    {
        try {
            $name = $customer->getName();
            $customer->delete();

            flash()->info(__('Customer :name has been deleted', ['name' => $name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));
        }

        return redirect(route('appshell.customer.index'));
    }
}
