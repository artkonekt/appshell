<?php
/**
 * Contains the BaseController class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-05-13
 *
 */


namespace Konekt\AppShell\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * Common base controller class for all appshell controllers
 * Basically it's a copy of the default controller from a
 * default app/Http/Controllers/Controller +  appshell
 */
abstract class BaseController extends Controller
{
    /** @var  string The namespace of the views */
    protected $viewNS;

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->viewNS = config('konekt.app_shell.views.namespace');
    }

    /**
     * A tiny wrapper for view() method that handles cases when the
     * 'appshell::' view namespace gets customized, or the cases
     * when no namespace gets specified by adding a namespace
     *
     * @param  string  $view
     * @param  array   $data
     * @param  array   $mergeData
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    protected function appShellView($view = null, $data = [], $mergeData = [])
    {
        if (!str_contains($view, '::')) {
            $view = sprintf('%s::%s', $this->viewNS, $view);
        } elseif (starts_with($view, 'appshell::')) {
            $view = str_replace_first('appshell::', $this->viewNS . '::', $view);
        }

        return view($view, $data, $mergeData);
    }
}