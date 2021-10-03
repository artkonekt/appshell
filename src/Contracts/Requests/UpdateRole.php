<?php

declare(strict_types=1);
/**
 * Contains the UpdateRole request interface.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-07-25
 *
 */

namespace Konekt\AppShell\Contracts\Requests;

use Konekt\Concord\Contracts\BaseRequest;

interface UpdateRole extends BaseRequest
{
    /**
     * Returns the permissions array
     *
     * @return array
     */
    public function permissions();
}
