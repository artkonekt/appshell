<?php
/**
 * Contains the SettingsTab interface.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-03-13
 *
 */


namespace Konekt\AppShell\Contracts;


interface SettingsTab
{
    /**
     * The id of the tab
     *
     * @return string
     */
    public function id() : string;

    /**
     * The label of the tab to be displayed for the user on the UI
     *
     * @return string
     */
    public function label() : string;

    /**
     * The order of the tab
     *
     * @return int|null
     */
    public function order();

    /**
     * Authorizes the access to this tab. Returns true if the tab
     * is allowed for the current user and/or application. Can
     * be used for checking against more complex auth logic
     *
     * @return bool
     */
    public function allowed() : bool;

    /**
     * Permission necessary to access the tab.
     * This is optional and can be used to
     * authorize against Acl permission
     * Return null and it is ignored
     *
     * @return null|string
     */
    public function permission();
}
