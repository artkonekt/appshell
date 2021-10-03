<?php

declare(strict_types=1);

/**
 * Contains the ExactMatch class.
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
use Konekt\AppShell\Filters\Concerns\DoesNotAllowMultipleValues;
use Konekt\AppShell\Filters\Concerns\HasBaseFilterAttributes;
use Konekt\AppShell\Filters\Concerns\HasGenericFilterConstructor;
use Konekt\AppShell\Filters\Concerns\HasPlaceholderSetter;
use Konekt\AppShell\Filters\Concerns\HasWidgetType;

class ExactMatch implements Filter
{
    use HasBaseFilterAttributes;
    use HasPlaceholderSetter;
    use HasGenericFilterConstructor;
    use HasWidgetType;
    use DoesNotAllowMultipleValues;

    public function apply(Builder $query, $criteria): Builder
    {
        if (null === $criteria) {
            return $query;
        }

        return $query->where($this->id, $criteria);
    }
}
