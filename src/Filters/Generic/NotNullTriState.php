<?php

declare(strict_types=1);

namespace Konekt\AppShell\Filters\Generic;

use Illuminate\Database\Eloquent\Builder;
use Konekt\AppShell\Contracts\Filter;
use Konekt\AppShell\Filters\Concerns\DoesNotAllowMultipleValues;
use Konekt\AppShell\Filters\Concerns\HasBaseFilterAttributes;
use Konekt\AppShell\Filters\Concerns\HasFieldSetter;
use Konekt\AppShell\Filters\Concerns\HasPlaceholderSetter;

class NotNullTriState implements Filter
{
    use HasBaseFilterAttributes;
    use DoesNotAllowMultipleValues;
    use HasPlaceholderSetter;
    use HasFieldSetter;

    public function __construct(
        string $id,
        string $labelNotNull,
        string $labelNull,
        string $labelAny,
        ?string $label = null
    ) {
        $this->id = $id;
        $this->placeholder = $labelAny;
        $this->possibleValues = [0 => $labelNull, 1 => $labelNotNull];
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

        return $criteria ? $query->whereNotNull($this->field()) : $query->whereNull($this->field());
    }
}
