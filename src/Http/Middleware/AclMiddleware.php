<?php

namespace Konekt\AppShell\Http\Middleware;

use Auth;
use Closure;
use Konekt\AppShell\Acl\ResourcePermissionMapper;

class AclMiddleware
{
    /** @var ResourcePermissionMapper */
    private $permissionMapper;

    public function __construct(ResourcePermissionMapper $permissionMapper)
    {
        $this->permissionMapper = $permissionMapper;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @param null                      $permission
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $permission = null)
    {
        $permission = $permission ?: $this->getNecessaryPermission($request->route()->getAction());

        if (false !== $permission) {
            if (! $request->user()->can($permission)) {
                abort(403);
            }
        }

        return $next($request);
    }

    /**
     * Returns permission name like 'edit users', 'list users' etc based on resource and action
     *
     * @param $action
     *
     * @return bool|string Returns the permission name or false if no matching action was found
     */
    protected function getNecessaryPermission($action)
    {
        $parsed = $this->parseAction($action);

        return $this->permissionMapper->permissionFor($parsed['resource'], $parsed['action']);
    }

    /**
     * @param array $action
     *
     * @return array
     */
    protected function parseAction($action)
    {
        // Remove namespace
        $parts         = explode('\\', $action['uses']);
        $ctrlAndAction = end($parts);

        // Split controller and action
        $parts      = explode('@', $ctrlAndAction);
        $controller = $parts[0];
        $action     = end($parts);
        $resource   = str_replace('Controller', '', $controller);

        return [
            'action'   => $action,
            'resource' => $resource
        ];
    }
}
