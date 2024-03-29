<?php

declare(strict_types=1);

/**
 * Contains the PartialMatch class.
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
use Konekt\AppShell\Filters\Concerns\HasPartialMatchPattern;
use Konekt\AppShell\Filters\Concerns\HasPlaceholderSetter;
use Konekt\AppShell\Filters\Concerns\HasWidgetType;
use Konekt\AppShell\Filters\PartialMatchPattern;

class PartialMatch implements Filter
{
    use HasBaseFilterAttributes;
    use HasPlaceholderSetter;
    use DoesNotAllowMultipleValues;
    use HasWidgetType;
    use HasPartialMatchPattern;

    public function __construct(
        string $id,
        ?string $label = null,
        PartialMatchPattern $pattern = null
    ) {
        $this->id = $id;
        $this->partialMatchPattern = $pattern;
        $this->label = $label;
        $this->placeholder = $label;
    }

    public function apply(Builder $query, $criteria): Builder
    {
        if (null === $criteria) {
            return $query;
        }

        $pattern = $this->partialMatchPattern ?? PartialMatchPattern::create();

        return $query->where($this->id, 'like', $pattern->sqlExpression($criteria));
    }
}
