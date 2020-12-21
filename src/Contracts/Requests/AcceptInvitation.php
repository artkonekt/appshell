<?php

declare(strict_types=1);

/**
 * Contains the AcceptInvitation interface.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-12-21
 *
 */

namespace Konekt\AppShell\Contracts\Requests;

use Konekt\Concord\Contracts\BaseRequest;
use Konekt\User\Contracts\Invitation;

interface AcceptInvitation extends BaseRequest
{
    public function getInvitation(): ?Invitation;
}
