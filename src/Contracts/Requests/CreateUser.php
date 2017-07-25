<?php
/**
 * Contains the CreateUser request interface.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-05-24
 *
 */


namespace Konekt\AppShell\Contracts\Requests;


interface CreateUser extends BaseRequest
{
    /**
     * Returns the roles array
     *
     * @return array
     */
    public function roles();

}