<?php

declare(strict_types=1);

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

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Konekt\Acl\Traits\HasRoles;
use Konekt\Customer\Contracts\Customer;
use Konekt\Customer\Models\CustomerProxy;
use Konekt\User\Models\User as BaseUser;

/**
 * @property int $customer_id
 * @property Customer|null $customer
 */
class User extends BaseUser
{
    use HasRoles;

    protected $fillable = [
        'name', 'email', 'password', 'type', 'is_active', 'customer_id',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(CustomerProxy::modelClass(), 'customer_id', 'id');
    }
}
