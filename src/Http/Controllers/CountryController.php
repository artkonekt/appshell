<?php

declare(strict_types=1);

namespace Konekt\AppShell\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Konekt\Address\Contracts\Country;
use Konekt\Address\Models\CountryProxy;
use Konekt\Address\Seeds\Countries;
use Konekt\AppShell\Contracts\Requests\CreateCountry;
use Konekt\AppShell\Contracts\Requests\UpdateCountry;

class CountryController extends BaseController
{
    public function index(): View
    {
        return view('appshell::country.index', [
            'countries' => CountryProxy::withCount('provinces as provinces_count')->get(),
        ]);
    }

    public function create(): View
    {
        $country = app(Country::class);

        return view('appshell::country.create', [
            'country' => $country,
        ]);
    }

    public function store(CreateCountry $request): RedirectResponse
    {
        try {
            if ($request->wantsToSeed()) {
                if (CountryProxy::count() < 0) {
                    flash()->error(__('Can not generate the data, because the list of countries is not empty'));

                    return redirect()->back()->withInput();
                }

                $seeder = new Countries();
                $seeder->run();

                flash()->success(__('The countries have been created'));
            } else {
                $country = CountryProxy::create($request->validated());
                flash()->success(__(':name has been created', ['name' => $country->name]));
            }
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('appshell.country.index'));
    }

    public function show(Country $country): View
    {
        return view('appshell::country.show', ['country' => $country]);
    }

    public function edit(Country $country): View
    {
        return view('appshell::country.edit', [
            'country' => $country,
        ]);
    }

    public function update(Country $country, UpdateCountry $request): RedirectResponse
    {
        try {
            $country->update($request->validated());

            flash()->success(__(':name has been updated', ['name' => $country->name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('appshell.country.index'));
    }

    public function destroy(Country $country): RedirectResponse
    {
        try {
            $name = $country->name;
            $country->delete();

            flash()->warning(__(':name has been deleted', ['name' => $name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back();
        }

        return redirect(route('appshell.country.index'));
    }
}
