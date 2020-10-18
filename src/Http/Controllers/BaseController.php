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

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

/**
 * Common base controller class for all AppShell controllers
 * Basically it's a copy of the default controller from a
 * default Laravel app's `Http/Controllers/Controller`
 */
abstract class BaseController extends Controller
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;
}
