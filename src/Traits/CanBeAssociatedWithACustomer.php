<?php

declare(strict_types=1);

/**
 * Contains the CanBeAssociatedWithACustomer trait.
 *
 * @copyright   Copyright (c) 2022 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2022-03-12
 *
 */

namespace Konekt\AppShell\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Konekt\Customer\Models\CustomerProxy;

trait CanBeAssociatedWithACustomer
{
    // Why don't we add this to the customer module?
    public function customer(): BelongsTo
    {
        return $this->belongsTo(CustomerProxy::modelClass(), 'customer_id', 'id');
    }

    public function isAssociatedWithACustomer(): bool
    {
        return null !== $this->customer_id;
    }

    public function isNotAssociatedWithACustomer(): bool
    {
        return !$this->isAssociatedWithACustomer();
    }
}
