<?php

declare(strict_types=1);
/**
 * Contains the CreateAddress interface.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-12-25
 *
 */

namespace Konekt\AppShell\Contracts\Requests;

interface CreateAddress extends CreateAddressForm
{
    public function getDataAttributes(): array;
}
