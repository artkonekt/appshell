<?php

declare(strict_types=1);

/**
 * Contains the UpdateInvitation class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-12-21
 *
 */

namespace Konekt\AppShell\Contracts\Requests;

use Konekt\Concord\Contracts\BaseRequest;
use Konekt\User\Contracts\UserType;

interface UpdateInvitation extends BaseRequest
{
    /** @return array */
    public function roles();

    public function getEmail(): string;

    public function getName(): ?string;

    public function getType(): UserType;

    public function getOptions(): array;

    public function getExpiryDays(): ?int;
}
