<?php
/**
 * Contains the UpdateAddress interface.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-11-02
 *
 */

namespace Konekt\AppShell\Contracts\Requests;

interface UpdateAddress extends EditAddressForm
{
    public function getDataAttributes(): array;
}
