<?php

declare(strict_types=1);

/**
 * Contains the HasGenericFilterConstructor trait.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-09-18
 *
 */

namespace Konekt\AppShell\Filters\Concerns;

trait HasGenericFilterConstructor
{
    public function __construct(
        string $id,
        ?string $label = null,
        ?array $possibleValues = null
    ) {
        $this->id = $id;
        $this->possibleValues = $possibleValues;
        $this->label = $label;
    }
}
