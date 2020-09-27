<?php

declare(strict_types=1);

/**
 * Contains the ResourcePermissionMapper class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-09-26
 *
 */

namespace Konekt\AppShell\Acl;

use Illuminate\Support\Str;

/**
 * Mapping between resource names like 'user', 'category', 'subscription', etc
 * and action names eg. 'index', 'show', 'store', etc
 *
 * Based on the idea of Laravel resource route/controller convention:
 * @see https://laravel.com/docs/8.x/controllers#resource-controllers
 * @see Route::resource()
 */
final class ResourcePermissionMapper
{
    private $actionVerbMap = [
        'index' => 'list',
        'create' => 'create',
        'store' => 'create',
        'show' => 'view',
        'edit' => 'edit',
        'update' => 'edit',
        'destroy' => 'delete',
    ];

    private $customPluralForms = [];

    /**
     * Returns permission verb like 'edit', 'list', etc based on Laravel resource action
     *
     * @param string $action Action name like 'index', 'show', 'create', 'store', etc
     *
     * @return null|string Returns the permission verb or null if no matching action was found
     */
    public function permissionVerbForAction(string $action): ?string
    {
        $verb = $this->actionVerbMap[$action] ?? null;

        if (null === $verb && config('konekt.app_shell.acl.allow_action_as_verb', false)) {
            $verb = str_replace('_', ' ', Str::snake($action));
        }

        return $verb;
    }

    /**
     * Returns the permission name for a specific resource and action
     *
     * @param string $resource Resource name eg. 'user', 'category', 'subscription'
     * @param string $action Action name eg. 'index', 'show', 'store'
     *
     * @return null|string Returns the permission name eg. "create users", "delete categories"
     */
    public function permissionFor(string $resource, string $action): ?string
    {
        if (!$verb = $this->permissionVerbForAction($action)) {
            return null;
        }

        return $verb . ' ' . $this->mappedResourceName($resource);
    }

    /**
     * Returns the resource name in the form as it's being used in the permissions context.
     *
     * @param string $resource Resource name eg. 'product', 'userType', etc
     *
     * @return string Returns the mapped name eg. "products", 'user_types', etc
     */
    public function mappedResourceName(string $resource): string
    {
        return str_replace('_', ' ', $this->plural(Str::snake(str_replace('-', '_', $resource))));
    }

    /**
     * Returns all the default permissions for a given resource
     *
     * @param string $resource Resource name eg. 'project', 'issueType'
     *
     * @return array Returns the list of known permissions for the given resource,
     *               eg. ['list issue_types', 'create issue_types', ...]
     */
    public function allPermissionsFor(string $resource): array
    {
        return array_values(array_map(
            function ($action) use ($resource) {
                return $this->permissionFor($resource, $action);
            },
            array_flip($this->actionVerbMap)
        ));
    }

    /**
     * Allows to override the pluralization for specific resources
     *
     * @see https://github.com/vanilophp/framework/issues/74
     *
     * @param string $resource Resource name eg. 'taxon'
     * @param string $pluralForm The custom plural form eg. 'taxons' (to override default 'taxa')
     */
    public function overrideResourcePlural(string $resource, string $pluralForm): void
    {
        $this->customPluralForms[$resource] = $pluralForm;
    }

    private function plural(string $word): string
    {
        return $this->customPluralForms[$word] ?? Str::plural($word);
    }
}
