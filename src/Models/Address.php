<?php

declare(strict_types=1);

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

/**
 * @todo instead of overloading the models, replace the Form:: functionality
 *       with an in-house solution. That solution needs to be enum aware
 *       by default, and implement a feature where subsequent modules
 *       and applications can register form accessors (decorators)
 *       eg.: FormAccessors::add(ModelContract::class, 'field', fn ($value) => transform($value));
 */
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
