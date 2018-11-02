<?php
/**
 * Contains the HasRoles request trait.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-07-25
 *
 */

namespace Konekt\AppShell\Http\Requests;

trait HasRoles
{
    /**
     * Returns the roles array
     *
     * @return array
     */
    public function roles()
    {
        $roles = $this->get('roles');

        return is_array($roles) ? array_keys($roles) : [];
    }
}
