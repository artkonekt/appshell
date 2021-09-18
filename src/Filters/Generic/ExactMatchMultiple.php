<?php

declare(strict_types=1);

/**
 * Contains the ExactMatchMultiple class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-09-18
 *
 */

namespace Konekt\AppShell\Filters\Generic;

use Illuminate\Database\Eloquent\Builder;
use Konekt\AppShell\Contracts\Filter;
use Konekt\AppShell\Filters\Concerns\AllowsMultipleValues;
use Konekt\AppShell\Filters\Concerns\HasBaseFilterAttributes;
use Konekt\AppShell\Filters\Concerns\HasGenericFilterConstructor;
use Konekt\AppShell\Filters\Concerns\HasPlaceholderSetter;

class ExactMatchMultiple implements Filter
{
    use HasBaseFilterAttributes;
    use HasPlaceholderSetter;
    use HasGenericFilterConstructor;
    use AllowsMultipleValues;

    public function apply(Builder $query, $criteria): Builder
    {
        if (empty($criteria)) {
            return $query;
        }

        return $query->whereIn($this->id, $criteria);
    }
}
