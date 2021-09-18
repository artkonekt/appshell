<?php

declare(strict_types=1);

/**
 * Contains the Filters class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-09-18
 *
 */

namespace Konekt\AppShell\Filters;

use ArrayIterator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use IteratorAggregate;
use Konekt\AppShell\Contracts\Filter;
use Konekt\AppShell\Exceptions\NonExistentFilterException;
use Konekt\AppShell\Filters\Generic\ExactMatch;

class Filters implements IteratorAggregate
{
    private array $items = [];

    /** @var ActiveFilter[] */
    private array $activeFilters = [];

    public function __construct(Filter ...$filters)
    {
        foreach ($filters as $filter) {
            $this->addFilter($filter);
        }
    }

    public static function make(array $filters): Filters
    {
        $instance = new self();
        foreach ($filters as $key => $value) {
            if ($value instanceof Filter) {
                $instance->addFilter($value);
            } elseif (is_numeric($key)) {
                if (is_string($value)) {
                    $instance->addFilter(self::makeFilterFromDefinition($value));
                } elseif(is_array($value) && array_key_exists('id', $value)) {
                    $instance->addFilter(self::makeFilterFromDefinition($value['id'], Arr::except($value, 'id')));
                } else {
                    throw new \InvalidArgumentException('Invalid Filter Definition ' . gettype($value));
                }
            } elseif (is_string($key)) {
                $instance->addFilter(self::makeFilterFromDefinition($key, $value ?: []));
            }
        }

        return $instance;
    }

    public function addFilter(Filter $filter): Filters
    {
        $this->items[$filter->id()] = $filter;

        return $this;
    }

    public function get(string $id): ?Filter
    {
        return $this->items[$id] ?? null;
    }

    public function apply(Builder $query): Builder
    {
        foreach ($this->activeFilters as $activeFilter) {
            $activeFilter->filter()->apply($query, $activeFilter->criteria());
        }

        return $query;
    }

    public function activateFromRequest(Request $request): void
    {
        foreach ($this->items as $id => $filter) {
            if ($request->has($id)) {
                $this->activate($id, $request->get($id));
            }
        }
    }

    public function activate(string $id, $criteria): Filters
    {
        $filter = $this->get($id);
        if (null === $filter) {
            throw new NonExistentFilterException("The filter `$id` does not exist on this set");
        }

        $this->activeFilters[$id] = new ActiveFilter($filter, $criteria);

        return $this;
    }

    public function deactivate(string $id): Filters
    {
        if ($this->exists($id)) {
            unset($this->activeFilters[$id]);
        }

        return $this;
    }

    /**
     * @return ActiveFilter[]
     */
    public function activeOnes(): array
    {
        return $this->activeFilters;
    }

    public function activeOne(string $id): ActiveFilter
    {
        return $this->activeFilters[$id];
    }

    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }

    private static function makeFilterFromDefinition(string $id, array $definition = []): Filter
    {
        $class = $definition['type'] ?? ExactMatch::class;

        return new $class($id);
    }

    private function exists(string $id): bool
    {
        return (bool) ($this->items[$id] ?? false);
    }
}
