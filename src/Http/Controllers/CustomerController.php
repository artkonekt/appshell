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
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Konekt\AppShell\Contracts\Requests\CreateCustomer;
use Konekt\AppShell\Contracts\Requests\UpdateCustomer;
use Konekt\AppShell\Filters\Filters;
use Konekt\AppShell\Filters\Generic\BoolTriState;
use Konekt\AppShell\Filters\Generic\PartialMatchInMultipleFields;
use Konekt\AppShell\Filters\PartialMatchPattern;
use Konekt\AppShell\Models\ChartResolution;
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

    public function show(Request $request, Customer $customer): View
    {
        $daily = new DateInterval('P1D');

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $period = new DatePeriod(Carbon::parse($request->input('start_date'))->startOfDay(), $daily, Carbon::parse($request->input('end_date'))->endOfDay());
        } else {
            $period = new DatePeriod(Carbon::now()->startOfMonth(), $daily, Carbon::now()->endOfMonth());
        }

        if ($request->filled('resolution')) {
            $resolution = $request->input('resolution');
        } else {
            $resolution = ChartResolution::DAILY;
        }

        $purchases = $customer
            ->purchases()
            ->whereBetween('purchase_date', [$period->start, $period->end])
            ->get();

        // Get an array where the keys are the dates of the period and fill it with 0s
        $customerPurchases = collect();
        $periodStart = $period->start->copy();
        $periodEnd = $period->end->copy();
        switch ($resolution) {
            case 'daily':
                while ($periodStart <= $periodEnd) {
                    $customerPurchases->put($periodStart->toDateString(), 0);
                    $periodStart->addDay();
                }
                break;
            case 'weekly':
                $endOfPeriod = $periodEnd;
                $startOfWeek = $periodStart;

                $endOfWeek = $startOfWeek->copy()->endOfWeek(Carbon::SUNDAY);

                // Adjust the end of the week if it exceeds the period's end date
                if ($endOfWeek > $endOfPeriod) {
                    $endOfWeek = $endOfPeriod;
                }

                // Add the first week to the resolutionDates collection
                $customerPurchases->put("{$startOfWeek->toDateString()} - {$endOfWeek->toDateString()}", 0);

                // If the whole period is within the first week, stop
                if ($endOfWeek === $endOfPeriod) {
                    break;
                }

                // Move to the next Monday and loop through the remaining weeks
                while ($endOfWeek < $endOfPeriod) {
                    $startOfWeek = $endOfWeek->copy()->addDay()->startOfWeek(Carbon::MONDAY);
                    $endOfWeek = $startOfWeek->copy()->endOfWeek(Carbon::SUNDAY);

                    // Adjust the end of the week if it exceeds the period's end date
                    if ($endOfWeek > $endOfPeriod) {
                        $endOfWeek = $endOfPeriod;
                    }

                    $customerPurchases->put("{$startOfWeek->toDateString()} - {$endOfWeek->toDateString()}", 0);
                }
                break;
            case 'monthly':
                while ($periodStart <= $periodEnd) {
                    $customerPurchases->put($periodStart->format('Y-m'), 0);
                    $periodStart->addMonth();
                }
                break;
            case 'annual':
                while ($periodStart <= $periodEnd) {
                    $customerPurchases->put($periodStart->format('Y'), 0);
                    $periodStart->addYear();
                }
                break;
        }

        $periodFormat = [
            'daily' => fn ($date) => $date->toDateString(),
            'monthly' => fn ($date) => $date->format('Y-m'),
            'annual' => fn ($date) => $date->format('Y'),
        ];

        // Calculate the sums for each key (date) of the $customerPurchases array
        foreach ($purchases as $purchase) {
            if ('weekly' === $resolution) {
                foreach ($customerPurchases as $key => $value) {
                    // Split the period key into start and end dates (e.g., '2024-11-01 - 2024-11-07')
                    [$startOfWeek, $endOfWeek] = explode(' - ', $key);

                    if ($purchase->purchase_date->between($startOfWeek, $endOfWeek)) {
                        $customerPurchases[$key] += $purchase->purchase_value;
                    }
                }
            } else {
                $periodKey = $periodFormat[$resolution]($purchase->purchase_date);

                if ($customerPurchases->has($periodKey)) {
                    $customerPurchases[$periodKey] += $purchase->purchase_value;
                }
            }
        }

        return view('appshell::customer.show', [
            'customer' => $customer,
            'customerPurchases' => $customerPurchases,
            'purchasesCount' => $purchases->count(),
            'resolutions' => ChartResolution::choices(),
            'period' => $period,
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
