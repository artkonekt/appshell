<?php
/**
 * Contains the ClientController class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-09-28
 *
 */


namespace Konekt\AppShell\Http\Controllers;


use Konekt\AppShell\Contracts\Requests\CreateClient;
use Konekt\AppShell\Contracts\Requests\UpdateClient;
use Konekt\Client\Contracts\Client;
use Konekt\Client\Models\ClientProxy;
use Konekt\Client\Models\ClientType;
use Konekt\Client\Models\ClientTypeProxy;

class ClientController extends BaseController
{
    /**
     * Displays the list of clients
     */
    public function index()
    {
        return $this->appShellView('client.index', [
            'clients' => ClientProxy::all()
        ]);
    }

    /**
     * Displays the create new client form
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $client = app(Client::class);

        return $this->appShellView('client.create', [
            'client' => $client,
            'types'  => ClientTypeProxy::choices()
        ]);
    }

    /**
     * @param CreateClient $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CreateClient $request)
    {
        try {
            ClientProxy::createClient(
                ClientTypeProxy::create($request->get('type')),
                $this->flattenInputArray($request->all())
            );

            flash()->success(__('Client has been created'));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        //@todo process route prefixes based on box config
        return redirect(route('appshell.client.index'));
    }

    /**
     * Show client
     *
     * @param Client $client
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Client $client)
    {
        return $this->appShellView('client.show', compact('client'));
    }

    /**
     * @param Client $client
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @internal param User $user
     *
     */
    public function edit(Client $client)
    {
        return $this->appShellView('client.edit', [
            'client'  => $client,
            'types'  => ClientTypeProxy::choices()
        ]);
    }

    /**
     * @param Client       $client
     * @param UpdateClient $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Client $client, UpdateClient $request)
    {
        try {
            $client->updateClient($this->flattenInputArray($request->all()));

            flash()->success(__('Client has been updated'));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        //@todo process route prefixes based on box config
        return redirect(route('appshell.client.index'));
    }

    /**
     * Delete a client
     *
     * @param Client $client
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Client $client)
    {
        try {
            $name = $client->name();
            $client->delete();

            flash()->warning(__('Client :name has been deleted', ['name' => $name]));

        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));
        }

        //@todo process route prefixes based on box config
        return redirect(route('appshell.client.index'));
    }


    /**
     * Converts the request array by flattening properties depending on type
     *
     * @return array
     */
    protected function flattenInputArray(array $input)
    {
        $result = array_only($input, ['type', 'is_active']);

        if (ClientType::INDIVIDUAL == $input['type']) {
            $result = array_merge($result, $input['person']);
        } else {
            $result = array_merge($result, $input['organization']);
        }

        return $result;
    }

}