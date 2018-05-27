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

use Illuminate\Http\Request;

class SettingsController extends BaseController
{
    /**
     * Displays the settings page
     */
    public function index()
    {
        return $this->appShellView('settings.index', [
            'tabs' => []
        ]);
    }

    public function update(Request $request)
    {
        //Settings::save($request->get('settings'));

        flash()->success(__('Settings have been saved'));

        return redirect()->route('appshell.settings.index');
    }
}
