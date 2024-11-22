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

use Carbon\Carbon;
use DateInterval;
use DatePeriod;
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
        $daily = new DateInterval('P1D');
        $currentMonth = new DatePeriod(Carbon::now()->startOfMonth(), $daily, Carbon::now()->endOfMonth());

        $period = $currentMonth;
        $resolution = 'weekly';

        // Determine the period based on the resolution
        switch ($resolution) {
            case 'daily':
                $period = new DatePeriod(Carbon::now()->startOfMonth(), $daily, Carbon::now()->endOfMonth());
                break;
            case 'weekly':
                $period = new DatePeriod(Carbon::now()->startOfWeek(), $daily, Carbon::now()->endOfMonth());
                break;
            case 'monthly':
                $period = new DatePeriod(Carbon::now()->startOfYear(), $daily, Carbon::now()->endOfYear());
                break;
            case 'annual':
                $period = new DatePeriod(Carbon::now()->startOfYear(), $daily, Carbon::now()->endOfYear());
                break;
        }

        $purchases = $customer
            ->purchases()
            ->whereBetween('purchase_date', [$period->start, $period->end])
            ->get();

        // Group and sum based on the resolution
        $groupedPurchases = $purchases->groupBy(function ($purchase) use ($resolution) {
            switch ($resolution) {
                case 'daily':
                    return $purchase->purchase_date->toDateString(); // Group by date
                case 'weekly':
                    // Start and end of the week
                    $startOfWeek = $purchase->purchase_date->startOfWeek()->toDateString();
                    $endOfWeek = $purchase->purchase_date->endOfWeek()->toDateString();
                    return "{$startOfWeek} - {$endOfWeek}"; // Group by week range
                case 'monthly':
                    return $purchase->purchase_date->format('Y-m'); // Group by month (YYYY-MM)
                case 'annual':
                    return $purchase->purchase_date->format('Y'); // Group by year (YYYY)
            }
        })->map(function ($group) {
            return $group->sum('purchase_value'); // Sum purchase_value for each group
        });

        // Generate all possible periods (weeks, months, etc.) within the range
        $allPeriods = collect();
        $currentDate = Carbon::now()->startOfMonth(); // Adjust this based on the resolution

        switch ($resolution) {
            case 'daily':
                // Loop through each day of the current month
                while ($currentDate <= Carbon::now()->endOfMonth()) {
                    $allPeriods->put($currentDate->toDateString(), 0);
                    $currentDate->addDay();
                }
                break;
            case 'weekly':
                // Loop through each week of the current month
                while ($currentDate <= Carbon::now()->endOfMonth()) {
                    $startOfWeek = $currentDate->startOfWeek()->toDateString();
                    $endOfWeek = $currentDate->endOfWeek()->toDateString();
                    $allPeriods->put("{$startOfWeek} - {$endOfWeek}", 0);
                    $currentDate->addWeek();
                }
                break;
            case 'monthly':
                // Loop through each month of the current year
                while ($currentDate <= Carbon::now()->endOfYear()) {
                    $allPeriods->put($currentDate->format('Y-m'), 0);
                    $currentDate->addMonth();
                }
                break;
            case 'annual':
                // Loop through each year
                while ($currentDate <= Carbon::now()->endOfYear()) {
                    $allPeriods->put($currentDate->format('Y'), 0);
                    $currentDate->addYear();
                }
                break;
        }

        // Merge the grouped purchases with all possible periods
        $finalPurchases = $allPeriods->merge($groupedPurchases);

        return view('appshell::customer.show', [
            'customer' => $customer,
            'customerPurchases' => $finalPurchases,
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
