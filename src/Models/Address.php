<?php
/**
 * Contains the Address class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-12-25
 *
 */

namespace Konekt\AppShell\Models;

use Konekt\Address\Models\Address as BaseAddress;
use Konekt\Customer\Models\CustomerProxy;
use Konekt\Enum\Eloquent\EnumsAreCompatibleWithLaravelForms;

class Address extends BaseAddress
{
    use EnumsAreCompatibleWithLaravelForms;

    /**
     * Relation for address' customers
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function customers()
    {
        return $this->belongsToMany(CustomerProxy::modelClass(), 'customer_addresses');
    }
}
