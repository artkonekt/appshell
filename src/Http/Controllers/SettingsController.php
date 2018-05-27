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
use Konekt\AppShell\Contracts\SettingsTree;
use Konekt\Gears\Facades\Settings;

class SettingsController extends BaseController
{
    public function index(SettingsTree $settingsTree)
    {
        return $this->appShellView('settings.index', [
            'tree' => $settingsTree
        ]);
    }

    public function update(Request $request)
    {
        Settings::update($request->get('settings'));

        flash()->success(__('Settings have been saved'));

        return redirect()->route('appshell.settings.index');
    }
}
