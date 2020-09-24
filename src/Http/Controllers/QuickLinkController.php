<?php
/**
 * Contains the QuickLinkController class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-09-09
 *
 */

namespace Konekt\AppShell\Http\Controllers;

use Illuminate\Http\Request;

class QuickLinkController extends BaseController
{
    public function index()
    {
        return view('appshell::quicklinks.index', [
            'links' => helper('quickLinks')->links()
        ]);
    }

    public function update(Request $request)
    {
        $result = [];
        $links  = $request->get('links');
        foreach ($request->get('labels') as $i => $label) {
            if (!empty($label) && !empty($links[$i])) {
                $result[$i] = [
                'label' => $label,
                'link'  => $links[$i]
            ];
            }
        }

        helper('quickLinks')->update($result);
        flash()->success(__('Quicklinks have been saved'));

        return redirect()->route('appshell.quicklinks.index');
    }
}
