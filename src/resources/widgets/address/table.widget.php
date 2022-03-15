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
                    'type' => 'multi_text',
                    'primary' => [
                        'text' => '$model.name',
                        'url' => [
                            'route' => 'appshell.address.edit',
                            'parameters' => ['$model']
                        ],
                        'onlyIfCan' => 'edit addresses',
                    ],
                    'secondary' => [
                        'text' => '$model.type',
                        'type' => 'badge',
                        'class' => '',
                        'color' => 'secondary'
                    ],
                ],
                'title' => __('Name'),
            ],
            'address' => [
                'title' => __('Address'),
            ],
            'country' => [
                'title' => __('Country'),
                'valign' => 'middle',
                'widget' => [
                    'type' => 'text',
                    'text' => '$model.country.name',
                ]
            ],
            'actions' => [
                'title' => '&nbsp;',
                'width' => '10%',
                'valign' => 'middle',
                'widget' => [
                    'type' => 'table_actions',
                    'actions' => [
                        'delete' => [
                            'route' => 'appshell.address.destroy',
                            'can' => 'delete addresses',
                            'confirm' => [
                                'text' => 'AAre you sure you want to delete this address?',
                            ]
                        ]
                    ]
                ]
            ]
        ],
        'empty' => [
            'text' => __('No addresses yet')
        ]
    ]
];
