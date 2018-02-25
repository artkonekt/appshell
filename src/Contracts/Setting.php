<?php
/**
 * Contains the Setting interface.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-02-25
 *
 */


namespace Konekt\AppShell\Contracts;


use Illuminate\Support\Collection;

interface Setting
{
    /**
     * Returns the key (identifier) of the setting
     *
     * @return string
     */
    public function key();

    /**
     * Returns the scope of the setting
     *
     * @return SettingScope
     */
    public function scope() : SettingScope;


    /**
     * Returns the permission name required to change the setting
     *
     * Permission should be registered with the Acl component.
     *
     * @return string|null
     */
    public function permission();

    /**
     * Requires the role name required to change the setting.
     * Permission takes precedence over a role.
     *
     * Role should be registered with the Acl component.
     *
     * @return string|null
     */
    public function role();

    /**
     * Returns the available options (if any) for the setting
     *
     * Eg. dropdown values, radio button values, etc
     *
     * @return null|Collection|array
     */
    public function options();

}
