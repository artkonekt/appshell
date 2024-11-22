<?php

declare(strict_types=1);

namespace Konekt\AppShell\Contracts\Requests;

use Konekt\Concord\Contracts\BaseRequest;

interface CreateProvince extends BaseRequest
{
    public function wantsToSeed(): bool;

    public function getSeederId(): ?string;
}
