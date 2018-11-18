<?php
/**
 * Contains the HasPermissions trait.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-07-25
 *
 */

namespace Konekt\AppShell\Http\Requests;

trait HasPermissions
{
    /**
     * Returns the permissions array
     *
     * @return array
     */
    public function permissions()
    {
        $perms = $this->get('permissions');

        return is_array($perms) ? array_keys($perms) : [];
    }
}
