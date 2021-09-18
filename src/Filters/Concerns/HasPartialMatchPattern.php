<?php

declare(strict_types=1);

/**
 * Contains the HasPartialMatchPattern trait.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-09-18
 *
 */

namespace Konekt\AppShell\Filters\Concerns;

use Konekt\AppShell\Filters\PartialMatchPattern;

trait HasPartialMatchPattern
{
    private ?PartialMatchPattern $partialMatchPattern = null;

    public function matchingPattern(PartialMatchPattern $pattern): void
    {
        $this->partialMatchPattern = $pattern;
    }
}
