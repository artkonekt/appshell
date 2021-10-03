<?php

declare(strict_types=1);

/**
 * Contains the CreateAddressForm interface.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-12-21
 *
 */

namespace Konekt\AppShell\Contracts\Requests;

use Illuminate\Database\Eloquent\Model;
use Konekt\Concord\Contracts\BaseRequest;

interface CreateAddressForm extends BaseRequest
{
    /**
     * Returns the entity the address needs to be created for
     *
     * @return null|Model
     */
    public function getFor();

    /**
     * Returns the eloquent relation name for the given "for" condition
     *
     * @return string|null
     */
    public function getForRelationName();
}
