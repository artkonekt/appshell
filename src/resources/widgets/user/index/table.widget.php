<?php

declare(strict_types=1);

use Konekt\AppShell\Widgets\AppShellWidgets;

return [
    'type' => AppShellWidgets::TABLE,
    'options' => [
        'striped' => true,
        'columns' => [
            'avatar' => [
                'widget' => 'avatar',
                'title' => '&nbsp;'
            ],
            'name' => [
                'widget' => [
                    'type' => 'multi_text',
                    'primary' => [
                        'text' => '$model.name',
                        'url' => [
                            'route' => 'appshell.user.show',
                            'parameters' => ['$model']
                        ],
                        'onlyIfCan' => 'view users',
                    ],
                    'secondary' => [
                        'text' => '$model.email'
                    ],
                ],
                'title' => __('Name'),
            ],
            'created_at' => [
                'title' => __('Registered'),
                'widget' => [
                    'type' => 'multi_text',
                    'primary' => [
                        'type' => 'show_date',
                        'text' => '$model.created_at',
                        'bold' => false,
                    ],
                    'secondary' => [
                        'text' => '$model.last_login_at',
                        'type' => 'show_datetime',
                        'prefix' => __('Last login') . ' ',
                        'unknown' => __('never')
                    ]
                ]
            ],
            'roles' => [
                'title' => __('Roles'),
                'widget' => [
                    'type' => 'badges',
                    'color' => 'dark',
                    'text' => '$model.name',
                    'items' => '$model.roles',
                ]
            ],
            'is_active' => [
                'title' => __('Status'),
                'widget' => [
                    'type' => 'badge',
                    'color' => ['bool' => ['success', 'secondary']],
                    'text' => '$model.is_active',
                    'filter' => sprintf('bool2text:%s,%s', __('active'), __('inactive'))
                ]
            ],
            'actions' => [
                'title' => '&nbsp;',
                'width' => '10%',
                'widget' => [
                    'type' => 'table_actions',
                    'actions' => [
                        'edit' => [
                            'route' => 'appshell.user.edit',
                            'can' => 'edit users',
                        ],
                        'delete' => [
                            'route' => 'appshell.user.destroy',
                            'can' => 'delete users',
                            'confirm' => [
                                'text' => 'Are you sure to delete poor :name?',
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
