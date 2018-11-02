<?php
/**
 * Contains the EditAddressForm interface.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-11-02
 *
 */

namespace Konekt\AppShell\Contracts\Requests;

use Illuminate\Database\Eloquent\Model;
use Konekt\Concord\Contracts\BaseRequest;

interface EditAddressForm extends BaseRequest
{
    /**
     * Returns the entity the address needs to be created for
     *
     * @return null|Model
     */
    public function getFor();
}
