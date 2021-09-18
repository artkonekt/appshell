<?php

declare(strict_types=1);

/**
 * Contains the ActiveFilter class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-09-18
 *
 */

namespace Konekt\AppShell\Filters;

use Konekt\AppShell\Contracts\Filter;

class ActiveFilter
{
    private Filter $filter;

    private $criteria;

    public function __construct(Filter $filter, $criteria)
    {
        $this->filter = $filter;
        $this->criteria = $criteria;
    }

    public function criteria()
    {
        return $this->criteria;
    }

    public function filter(): Filter
    {
        return $this->filter;
    }
}
