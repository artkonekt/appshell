<?php

declare(strict_types=1);

use Konekt\Acl\Models\RoleProxy;
use Konekt\AppShell\Widgets\AppShellWidgets;

return [
    'type' => AppShellWidgets::FILTER_SET,
    'options' => [
        'route' => 'appshell.user.index',
        'filters' => [
            'is_active',
            'roles' => [
                'multiselect' => true,
                'values' => [RoleProxy::modelClass(), 'all()']
            ],
        ]
    ]
];
