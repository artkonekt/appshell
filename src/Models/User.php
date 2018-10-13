<?php
/**
 * Contains the User class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-06-08
 *
 */


namespace Konekt\AppShell\Models;

use Konekt\Acl\Traits\HasRoles;
use Konekt\User\Models\User as BaseUser;

class User extends BaseUser
{
    use HasRoles;
}
