<?php

declare(strict_types=1);

use Konekt\AppShell\Widgets\AppShellWidgets;

return [
    'type' => AppShellWidgets::TABLE,
    'options' => [
        'hover' => true,
        'columns' => [
            'name' => [
                'widget' => [
                    'type' => 'link',
                    'text' => [
                        'bold' => true,
                        'text' => '$model.name',
                    ],
                    'url' => [
                        'route' => 'appshell.role.show',
                        'parameters' => ['$model']
                    ],
                    'onlyIfCan' => 'view roles',
                ],
                'title' => __('Name')
            ],
            'updated_at' => [
                'type' => 'show_datetime',
                'title' => __('Last update'),
            ],
            'users' => [
                'title' => __('Users'),
                'valign' => 'middle',
                'widget' => [
                    'type' => 'badge',
                    'color' => 'primary',
                    'text' => '$model.users',
                    'modifier' => 'count'
                ]
            ],
        ]
    ]
];
