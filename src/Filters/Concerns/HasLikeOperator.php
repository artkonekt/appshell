<?php

declare(strict_types=1);

namespace Konekt\AppShell\Filters\Concerns;

trait HasLikeOperator
{
    protected string $likeOperator = 'like';

    public function useILikeOperator(): self
    {
        $this->likeOperator = 'ilike';

        return $this;
    }
}
