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

use Illuminate\Support\Collection;
use Konekt\Acl\Traits\HasRoles;
use Konekt\Customer\Models\CustomerProxy;
use Konekt\Customer\Traits\BelongsToACustomer;
use Konekt\Customer\Traits\CustomerIsOptional;
use Konekt\User\Models\User as BaseUser;

/**
 * @method static User create(array $attributes)
 */
class User extends BaseUser
{
    use HasRoles;
    use BelongsToACustomer;
    use CustomerIsOptional;

    protected $fillable = [
        'name', 'email', 'password', 'type', 'is_active', 'customer_id',
    ];

    public function customersVisible(): Collection
    {
        if (!$this->can('list customers')) {
            return $this->isAssociatedWithACustomer() ?
                collect([$this->customer]) :
                collect();
        }

        return CustomerProxy::all()->sortBy('name');
    }
}
