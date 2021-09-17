<?php

declare(strict_types=1);

use Konekt\Acl\Models\RoleProxy;
use Konekt\AppShell\Widgets\AppShellWidgets;
use Konekt\AppShell\Widgets\FilterType;

return [
    'type' => AppShellWidgets::FILTER_SET,
    'options' => [
        'route' => 'appshell.user.index',
        'filters' => [
            'name',
            'is_active' => [
                'type' => 'select',
                'title' => __('Any status'),
                'options' => ['1' => 'Actives only', '0' => 'Inactives only']
            ],
            'roles' => [
                'type' => FilterType::MULTISELECT,
                'title' => __('Roles'),
                'options' => [
                    'call' => [RoleProxy::modelClass(), 'all'],
                    'pluck' => ['id', 'name'],
                ],
            ],
        ]
    ]
];
