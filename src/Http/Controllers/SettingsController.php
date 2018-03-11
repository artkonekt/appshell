<?php
/**
 * Contains the Settings Controller class.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-03-10
 *
 */


namespace Konekt\AppShell\Http\Controllers;


class SettingsController extends BaseController
{
    /**
     * Displays the settings page
     */
    public function index()
    {
        return $this->appShellView('settings.index', [

        ]);
    }

}