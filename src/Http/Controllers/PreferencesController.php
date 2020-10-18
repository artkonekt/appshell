<?php
/**
 * Contains the PreferencesController class.
 *
 * @copyright   Copyright (c) 2019 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2019-06-05
 *
 */

namespace Konekt\AppShell\Http\Controllers;

use Illuminate\Http\Request;
use Konekt\Gears\Facades\Preferences;

class PreferencesController extends BaseController
{
    public function index()
    {
        return view('appshell::preferences.index', [
            'tree' => app('appshell.preferences_tree')
        ]);
    }

    public function update(Request $request)
    {
        Preferences::update($request->get('preferences'));

        flash()->success(__('Preferences have been saved'));

        return redirect()->route('appshell.preferences.index');
    }
}
