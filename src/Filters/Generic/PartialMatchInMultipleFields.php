<?php

declare(strict_types=1);

/**
 * Contains the PartialMatchInMultipleFields class.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-01-26
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

class PartialMatchInMultipleFields implements Filter
{
    use HasBaseFilterAttributes;
    use HasPlaceholderSetter;
    use DoesNotAllowMultipleValues;
    use HasWidgetType;
    use HasPartialMatchPattern;

    private array $fields;

    public function __construct(
        string $id,
        array $fields,
        string $label,
        PartialMatchPattern $pattern = null
    ) {
        $this->id = $id;
        $this->fields = $fields;
        $this->partialMatchPattern = $pattern;
        $this->label = $label;
        $this->placeholder = $label;
        $this->displayAsTextField();
    }

    public function apply(Builder $query, $criteria): Builder
    {
        if (null === $criteria) {
            return $query;
        }

        $pattern = $this->partialMatchPattern ?? PartialMatchPattern::create();
        $fields = $this->fields;

        return $query->where(function (Builder $query) use ($pattern, $criteria, $fields) {
            foreach ($fields as $field) {
                $query->orWhere($field, 'like', $pattern->sqlExpression($criteria));
            }
        });
    }
}
