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
                'title' => 'Invitation'
            ],
            'invitation' => [
                'widget' => [
                    'type' => 'multi_text',
                    'primary' => [
                        'text' => '$model.email',
                        'url' => [
                            'route' => 'appshell.invitation.show',
                            'parameters' => ['$model']
                        ],
                        'onlyIfCan' => 'view invitations',
                    ],
                    'secondary' => [
                        'text' => '$model.name'
                    ],
                ],
                'title' => '',
            ],
            'created_at' => [
                'title' => __('Invited at'),
                'widget' => [
                    'type' => 'multi_text',
                    'primary' => [
                        'type' => 'show_date',
                        'text' => '$model.created_at',
                        'bold' => false,
                    ],
                    'secondary' => [
                        'text' => '$model.expires_at',
                        'type' => 'show_datetime',
                        'prefix' => __('Expires at') . ' ',
                        'unknown' => __('never')
                    ]
                ]
            ],
            'type' => [
                'title' => __('User Type'),
                'valign' => 'middle',
                'widget' => [
                    'type' => 'badge',
                    'color' => 'primary',
                    'text' => '$model.type',
                ]
            ],
            'roles' => [
                'title' => __('Roles'),
                'valign' => 'middle',
                'widget' => [
                    'type' => 'badges',
                    'color' => 'dark',
                    'text' => '$model.name',
                    'items' => '$model.roles',
                ]
            ],
            'status' => [
                'title' => __('Status'),
                'valign' => 'middle',
                'widget' => [
                    'type' => 'badge',
                    'color' => ['value' => '$model.color'],
                    'text' => '$model.status',
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
                            'route' => 'appshell.invitation.edit',
                            'can' => 'edit invitations',
                        ],
                        'delete' => [
                            'route' => 'appshell.invitation.destroy',
                            'can' => 'delete invitations',
                            'confirm' => [
                                'text' => 'Are you sure to cancel the invitation of :email?',
                                'params' => [
                                    'email' => '$model.email'
                                ],
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
];
