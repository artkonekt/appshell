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
                    'type' => 'multi_text',
                    'primary' => [
                        'text' => '$model.name',
                        'url' => [
                            'route' => 'appshell.customer.show',
                            'parameters' => ['$model']
                        ],
                        'onlyIfCan' => 'view customers',
                    ],
                    'secondary' => [
                        'text' => '$model.firstname $model.lastname'
                    ],
                ],
                'title' => __('Name'),
            ],
            'ltv' => [
                'title' => __('Sales'),
                'widget' => [
                    'type' => 'multi_text',
                    'primary' => [
                        'type' => 'text',
                        'text' => '$model.ltv',
                        'modifier' => 'number_format',
                        'suffix' => ' $model.currency',
                        'bold' => false,
                    ],
                    'secondary' => [
                        'text' => '$model.last_purchase_at',
                        'type' => 'show_date',
                        'prefix' => __('Last purchase') . ' ',
                        'unknown' => __('never')
                    ]
                ]
            ],
            'type' => [
                'title' => __('Type'),
                'valign' => 'middle',
                'widget' => [
                    'type' => 'enum_icon',
                    'value' => '$model.type'
                ]
            ],
            'is_active' => [
                'title' => __('Status'),
                'valign' => 'middle',
                'widget' => [
                    'type' => 'badge',
                    'color' => ['bool' => ['success', 'secondary']],
                    'text' => '$model.is_active',
                    'modifier' => sprintf('bool2text:%s,%s', __('active'), __('inactive'))
                ]
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
                        'text' => '$model.timezone',
                        'prefix' => __('Time zone') . ' ',
                        'unknown' => __('default')
                    ]
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
                            'route' => 'appshell.customer.edit',
                            'can' => 'edit customers',
                        ],
                        'delete' => [
                            'route' => 'appshell.customer.destroy',
                            'can' => 'delete customers',
                            'confirm' => [
                                'text' => 'Are you sure to delete :name?',
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
