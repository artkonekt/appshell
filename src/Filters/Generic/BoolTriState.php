<?php

declare(strict_types=1);

/**
 * Contains the BoolTriState class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-09-20
 *
 */

namespace Konekt\AppShell\Filters\Generic;

use Illuminate\Database\Eloquent\Builder;
use Konekt\AppShell\Contracts\Filter;
use Konekt\AppShell\Filters\Concerns\DoesNotAllowMultipleValues;
use Konekt\AppShell\Filters\Concerns\HasBaseFilterAttributes;
use Konekt\AppShell\Filters\Concerns\HasPlaceholderSetter;

class BoolTriState implements Filter
{
    use HasBaseFilterAttributes;
    use DoesNotAllowMultipleValues;
    use HasPlaceholderSetter;

    public function __construct(
        string $id,
        string $labelTrue,
        string $labelFalse,
        string $labelAny,
        string $label = null
    ) {
        $this->id = $id;
        $this->placeholder = $labelAny;
        $this->possibleValues = [0 => $labelFalse, 1 => $labelTrue];
        $this->label = $label ?? $id;
    }

    public function widgetType(): string
    {
        return 'select';
    }

    public function apply(Builder $query, $criteria): Builder
    {
        if (null === $criteria) {
            return $query;
        }

        return $query->where($this->id, (bool) $criteria);
    }
}
