<?php

declare(strict_types=1);

/**
 * Contains the Filter interface.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-09-18
 *
 */

namespace Konekt\AppShell\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface Filter
{
    public function id(): string;

    public function label(): string;

    public function placeholder(): ?string;

    public function searchable(): bool;

    public function widgetType(): string;

    public function possibleValues($context = null): ?array;

    public function allowsMultipleValues(): bool;

    public function apply(Builder $query, $criteria): Builder;
}
