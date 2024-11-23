<?php

declare(strict_types=1);

namespace Konekt\AppShell\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Konekt\Address\Contracts\Country;
use Konekt\Address\Contracts\Province;
use Konekt\Address\Contracts\ProvinceSeeder;
use Konekt\Address\Models\ProvinceProxy;
use Konekt\Address\Models\ProvinceTypeProxy;
use Konekt\Address\Seeds\ProvinceSeeders;
use Konekt\AppShell\Contracts\Requests\CreateProvince;
use Konekt\AppShell\Contracts\Requests\UpdateProvince;

class ProvinceController extends BaseController
{
    public function create(Country $country): View
    {
        $province = app(Province::class);

        return view('appshell::province.create', [
            'country' => $country,
            'province' => $province,
            'provinces' => $country->provinces,
            'types' => ProvinceTypeProxy::choices(),
        ]);
    }

    public function store(Country $country, CreateProvince $request): RedirectResponse
    {
        try {
            if ($request->wantsToSeed()) {
                if ($country->provinces->isNotEmpty()) {
                    flash()->error(__('Can not generate the data, because the list of provinces is not empty'));

                    return redirect()->back()->withInput();
                }

                /** @var ProvinceSeeder $seeder */
                $seeder = ProvinceSeeders::make($request->getSeederId());
                $seeder->run();

                flash()->success(__(':name have been successfully created', ['name' => $seeder::getName()]));
            } else {
                $province = ProvinceProxy::create(
                    array_merge(
                        $request->validated(),
                        ['country_id' => $country->id]
                    )
                );

                flash()->success(__(':name has been added to :country', [
                    'name' => $province->name,
                    'country' => $country->name
                ]));
            }
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('appshell.country.show', $country));
    }

    public function show(Country $country, Province $province): View
    {
        return view('appshell::province.show', [
            'country' => $country,
            'province' => $province
        ]);
    }

    public function edit(Country $country, Province $province): View
    {
        return view('appshell::province.edit', [
            'country' => $country,
            'province' => $province,
            'provinces' => $country->provinces->where('id', '!=', $province->id),
            'types' => ProvinceTypeProxy::choices(),
        ]);
    }

    public function update(Country $country, Province $province, UpdateProvince $request): RedirectResponse
    {
        try {
            $province->update($request->validated());

            flash()->success(__(':name has been updated', ['name' => $province->name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('appshell.country.show', $country));
    }

    public function destroy(Country $country, Province $province): RedirectResponse
    {
        try {
            $name = $province->name;
            $province->delete();

            flash()->warning(__(':name has been removed from :country', ['name' => $name, 'country' => $country->name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back();
        }

        return redirect(route('appshell.country.show', $country));
    }
}
