<?php

declare(strict_types=1);
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

use Illuminate\Http\Request;
use Konekt\AppShell\Contracts\Requests\CreateCustomer;
use Konekt\AppShell\Contracts\Requests\UpdateCustomer;
use Konekt\AppShell\Filters\Filters;
use Konekt\AppShell\Filters\Generic\BoolTriState;
use Konekt\AppShell\Filters\Generic\PartialMatchInMultipleFields;
use Konekt\AppShell\Filters\PartialMatchPattern;
use Konekt\AppShell\Settings\DefaultCurrency;
use Konekt\AppShell\Widgets;
use Konekt\AppShell\Widgets\AppShellWidgets;
use Konekt\Customer\Contracts\Customer;
use Konekt\Customer\Models\CustomerProxy;
use Konekt\Customer\Models\CustomerTypeProxy;
use Konekt\Gears\Facades\Settings;

class CustomerController extends BaseController
{
    public function index(Request $request)
    {
        $filters = Filters::make([
            new PartialMatchInMultipleFields('name', ['firstname', 'lastname', 'company_name'], __('Name'), PartialMatchPattern::ANYWHERE()),
            new BoolTriState('is_active', __('Actives only'), __('Inactives only'), __('Any status'), __('Status')),
        ]);

        $filters->activateFromRequest($request);

        return view('appshell::customer.index', [
            'customers' => $filters->apply(CustomerProxy::query())->paginate(100)->withQueryString(),
            'table' => widget('appshell::customer.index.table'),
            'filters' => Widgets::make(AppShellWidgets::FILTER_SET, [
                'route' => 'appshell.customer.index',
                'filters' => $filters,
            ])
        ]);
    }

    public function create()
    {
        /** @var \Konekt\Customer\Models\Customer $customer */
        $customer = app(Customer::class);
        $customer->timezone = config('app.timezone');
        $customer->is_active = true;
        $customer->currency = Settings::get('appshell.default.currency');

        return view('appshell::customer.create', [
            'customer' => $customer,
            'currencies' => (new DefaultCurrency())->options(),
            'types' => CustomerTypeProxy::choices()
        ]);
    }

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

    public function show(Customer $customer)
    {
        return view('appshell::customer.show', [
            'customer' => $customer
        ]);
    }

    public function edit(Customer $customer)
    {
        return view('appshell::customer.edit', [
            'customer' => $customer,
            'currencies' => (new DefaultCurrency())->options(),
            'types' => CustomerTypeProxy::choices()
        ]);
    }

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
