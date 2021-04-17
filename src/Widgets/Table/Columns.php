<?php

declare(strict_types=1);

/**
 * Contains the Columns class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-01-09
 *
 */

namespace Konekt\AppShell\Widgets\Table;

use ArrayAccess;
use Illuminate\Support\Collection;
use IteratorAggregate;

class Columns implements ArrayAccess, IteratorAggregate
{
    private Collection $columns;

    public function __construct(array $columns = [])
    {
        $this->columns = collect([]);
        $this->addColumns($columns);
    }

    public function addColumns(array $columns)
    {
        foreach ($columns as $id => $definition) {
            if (is_numeric($id) && is_string($definition)) { // We have a bare list of columns ['id', 'name']
                $this->addColumn($definition);
            } else {
                $this->addColumn($id, $definition);
            }
        }
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

    private function addColumn(string $id, array $attributes = []): Column
    {
        $column = new Column($id, $attributes);
        $this->columns->add($column);

        return $column;
    }
}
