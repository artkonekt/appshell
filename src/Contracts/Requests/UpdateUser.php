<?php
/**
 * Contains the UpdateUser request interface.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-05-24
 *
 */

namespace Konekt\AppShell\Contracts\Requests;

use Konekt\Concord\Contracts\BaseRequest;

interface UpdateUser extends BaseRequest
{
    /**
     * Returns the roles array
     *
     * @return array
     */
    public function roles();

    /**
     * Returns whether the password is about to be changed
     *
     * @return bool
     */
    public function wantsPasswordChange(): bool;

    /**
     * Returns the new password if it's about to be changed, null otherwise
     *
     * @return null|string
     */
    public function getNewPassword();
}
