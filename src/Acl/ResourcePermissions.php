<?php
/**
 * Contains the ResourcePermissions class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-07-26
 *
 */


namespace Konekt\AppShell\Acl;

use Konekt\Acl\Models\PermissionProxy;
use Konekt\Acl\PermissionRegistrar;

/**
 * Utility class for handling standard resource permissions
 */
class ResourcePermissions
{
    public static $permissions = ['list', 'create', 'view', 'edit', 'delete'];

    /**
     * Creates the resource permissions for the given resource(s)
     * Eg: resource: 'user' creates 'list users', 'create users', ... etc
     *
     * @param string|array $resources One or more resources to create resource permissions for
     *                                Eg. ('product' or ['product', 'category'])
     *
     * @return \Illuminate\Support\Collection
     */
    public static function createPermissionsForResource($resources)
    {
        $resources = is_array($resources) ? $resources : [$resources];
        $result    = collect();

        foreach ($resources as $resource) {
            foreach (static::allPermissionsFor($resource) as $name) {
                $result->put($name, PermissionProxy::create(['name' => $name]));
            }
        }

        return $result;
    }

    /**
     * Deletes permissions for a resource (opposite of createPermissionsForResource)
     *
     * @see self::createPermissionsForResource
     *
     * @param $resources
     *
     * @return int  Returns the count of removed permissions
     */
    public static function deletePermissionsForResource($resources)
    {
        $resources = is_array($resources) ? $resources : [$resources];
        $result    = 0;

        foreach ($resources as $resource) {
            foreach (static::allPermissionsFor($resource) as $name) {
                PermissionProxy::where(['name' => $name])->delete();
                $result++;
            }
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return $result;
    }

    /**
     * Returns permission verb like 'edit', 'list', etc based on Laravel resource action
     *
     * @param $action
     *
     * @return bool|string Returns the permission verb or false if no matching action was found
     */
    public static function permissionVerbForAction($action)
    {
        switch ($action) {
            case 'index':
                return 'list';
                break;
            case 'show':
                return 'view';
                break;
            case 'edit':
            case 'update':
                return 'edit';
                break;
            case 'create':
            case 'store':
                return 'create';
                break;
            case 'destroy':
                return 'delete';
                break;
            default:
                return false;
        }
    }

    /**
     * Returns the permission name for a specific resource and action (Laravel std)
     *
     * @param string $resource  Resource name eg. 'user', 'category', 'subscription'
     * @param string $action    Action name eg. 'index', 'show', 'store'
     *
     * @see https://laravel.com/docs/5.4/controllers#resource-controllers
     * @see Route::resource()
     *
     * @return bool|string
     */
    public static function permissionFor($resource, $action)
    {
        if (! $verb = ResourcePermissions::permissionVerbForAction($action)) {
            return false;
        }

        return sprintf('%s %s', $verb, str_plural($resource));
    }

    /**
     * Returns all the standard permissions for a resource
     *
     * @param $resource
     *
     * @return array
     */
    public static function allPermissionsFor($resource)
    {
        $result = [];
        foreach (static::$permissions as $permission) {
            $result[] = sprintf('%s %s', $permission, str_plural($resource));
        }

        return $result;
    }
}
