<?php

declare(strict_types=1);

namespace Konekt\AppShell\Filters\Concerns;

trait HasFieldSetter
{
    public function setField(string $field): self
    {
        $this->field = $field;

        return $this;
    }
}
