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


use Konekt\Address\Contracts\Organization;
use Konekt\Address\Contracts\Person;
use Konekt\AppShell\Contracts\Requests\CreateClient;
use Konekt\Client\Contracts\Client;
use Konekt\Client\Contracts\ClientType as ClientTypeContract;
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
        $type = ClientTypeProxy::create($request->get('type'));
        $data = $request->get($this->getClientTypeArrayKey($type));

        try {
            ClientProxy::createClient($type, $data);

            flash()->success(__('Client has been created'));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));
            return redirect()->back();
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
     * Returns the array key to be used to return data from the request that depending on the client type
     *
     * @param ClientTypeContract $clientType
     *
     * @return string
     */
    protected function getClientTypeArrayKey(ClientTypeContract $clientType)
    {
        switch ($clientType->value()) {
            case ClientType::INDIVIDUAL:
                return 'person';
                break;

            case ClientType::ORGANIZATION:
                return 'organization';
                break;
        }
    }

}