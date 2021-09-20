<?php

declare(strict_types=1);

/**
 * Contains the SomeFilter class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-09-18
 *
 */

namespace Konekt\AppShell\Tests\Dummies;

use Illuminate\Database\Eloquent\Builder;
use Konekt\AppShell\Contracts\Filter;

class SomeFilter implements Filter
{
    private string $name;

    public function __construct(string $name = 'some field')
    {
        $this->name = $name;
    }

    public function id(): string
    {
        return $this->name;
    }

    public function label(): string
    {
        return $this->name;
    }

    public function placeholder(): ?string
    {
        return null;
    }

    public function widgetType(): string
    {
        return 'select';
    }

    public function possibleValues($context = null): ?array
    {
        return null;
    }

    public function allowsMultipleValues(): bool
    {
        return false;
    }

    public function apply(Builder $query, $criteria): Builder
    {
        return $query;
    }
}
