<?php

declare(strict_types=1);

/**
 * Contains the Footer class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-10-08
 *
 */

namespace Konekt\AppShell\Widgets\Table;

use ArrayAccess;
use Illuminate\Support\Collection;
use IteratorAggregate;

class Footer implements ArrayAccess, IteratorAggregate
{
    private Collection $columns;

    public function __construct(array $columns = [])
    {
        $this->columns = collect([]);
        $this->addColumns($columns);
    }

    public function addColumns(array $columns)
    {
        foreach ($columns as $column) {
            $this->addColumn(is_array($column) ? $column : ['text' => $column]);
        }
    }

    public function hasColumn(int $index): bool
    {
        return $this->offsetExists($index);
    }

    public function offsetExists($offset)
    {
        return $this->columns->offsetExists($offset);
    }

    public function offsetGet($offset)
    {
        return $this->columns->offsetGet($offset);
    }

    public function offsetSet($offset, $value)
    {
        $this->columns->offsetSet($offset, $value);
    }

    public function offsetUnset($offset)
    {
        $this->columns->offsetUnset($offset);
    }

    public function getIterator()
    {
        return $this->columns->getIterator();
    }

    private function addColumn($definition): FooterColumn
    {
        $column = new FooterColumn($definition);
        $this->columns->add($column);

        return $column;
    }
}
