<?php

declare(strict_types=1);

/**
 * Contains the DoesNotAllowMultipleValues trait.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-09-18
 *
 */

namespace Konekt\AppShell\Filters\Concerns;

trait DoesNotAllowMultipleValues
{
    public function allowsMultipleValues(): bool
    {
        return false;
    }
}
