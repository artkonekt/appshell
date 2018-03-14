<?php
/**
 * Contains the SettingsSlice interface
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-03-14
 *
 */


namespace Konekt\AppShell\Contracts;


interface SettingsSlice
{
    /**
     * The id of the item
     *
     * @return string
     */
    public function id() : string;

    /**
     * The label of the item to be displayed for the user on the UI
     *
     * @return string
     */
    public function label() : string;

    /**
     * The sorting order of the item
     *
     * @return int|null
     */
    public function order();

    /**
     * Authorizes the access to this item. Returns true if access
     * is allowed for the current user and/or application. Can
     * be used for checking against more complex auth logic
     *
     * @return bool
     */
    public function allowed() : bool;

    /**
     * Permission required to access the item
     * This is optional and can be used to
     * authorize against Acl permission
     * Return null and it is ignored
     *
     * @return null|string
     */
    public function permission();
}
