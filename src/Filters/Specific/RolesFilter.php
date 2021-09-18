<?php

declare(strict_types=1);

/**
 * Contains the RolesFilter class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-09-18
 *
 */

namespace Konekt\AppShell\Filters\Specific;

use Illuminate\Database\Eloquent\Builder;
use Konekt\Acl\Models\RoleProxy;
use Konekt\AppShell\Contracts\Filter;
use Konekt\AppShell\Filters\Concerns\AllowsMultipleValues;
use Konekt\AppShell\Filters\Concerns\HasBaseFilterAttributes;

class RolesFilter implements Filter
{
    use HasBaseFilterAttributes;
    use AllowsMultipleValues;

    public function __construct(
        string $id = 'roles',
        ?string $label = null,
        ?string $placeholder = null
    ) {
        $this->id = $id;
        $this->label = $label ?? __('Roles');
        $this->placeholder = $placeholder;
    }

    public function apply(Builder $query, $criteria): Builder
    {
        return $query->whereHas('roles', function ($query) use ($criteria) {
            $query->where(function ($query) use ($criteria) {
                foreach ($criteria as $role) {
                    $query->orWhere('roles.id', $role);
                }
            });
        });
    }

    protected function loadPossibleValues($context = null): array
    {
        return RoleProxy::get(['id', 'name'])->pluck('name', 'id')->toArray();
    }
}
