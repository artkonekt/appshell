<?php

declare(strict_types=1);

use Konekt\AppShell\Widgets\AppShellWidgets;

return [
    'type' => AppShellWidgets::TABLE,
    'options' => [
        'striped' => true,
        'columns' => [
            'name' => [
                'widget' => [
                    'type' => 'link',
                    'text' => '$model.name',
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
            'actions' => [
                'title' => '&nbsp;',
                'width' => '10%',
                'valign' => 'middle',
                'widget' => [
                    'type' => 'table_actions',
                    'actions' => [
                        'edit' => [
                            'route' => 'appshell.role.edit',
                            'can' => 'edit roles',
                        ],
                        'delete' => [
                            'route' => 'appshell.role.destroy',
                            'can' => 'delete roles',
                            'confirm' => [
                                'text' => 'Are you sure to delete the :name role?',
                                'params' => [
                                    'name' => '$model.name'
                                ],
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
];
