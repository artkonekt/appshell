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


use Konekt\Client\Models\ClientProxy;

class ClientController extends BaseController
{
    /**
     * Displays the list of users
     */
    public function index()
    {
        return $this->appShellView('client.index', [
            'clients' => ClientProxy::all()
        ]);
    }

}