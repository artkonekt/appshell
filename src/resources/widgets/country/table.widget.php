<?php

declare(strict_types=1);

use Konekt\AppShell\Widgets\AppShellWidgets;

return [
    'type' => AppShellWidgets::TABLE,
    'options' => [
        'hover' => true,
        'empty' => ['text' => __('No countries on record')],
        'columns' => [
            'name' => [
                'widget' => [
                    'type' => 'link',
                    'text' => [
                        'bold' => true,
                        'text' => '$model.name',
                    ],
                    'url' => [
                        'route' => 'appshell.country.show',
                        'parameters' => ['$model']
                    ],
                    'onlyIfCan' => 'view countries',
                ],
                'title' => __('Name')
            ],
            'phonecode' => [
                'title' => __('Phone Code'),
                'valign' => 'middle',
                'widget' => [
                    'type' => 'text',
                    'text' => '$model.phonecode',
                ]
            ],
            'province_count' => [
                'title' => __('Provinces'),
                'valign' => 'middle',
                'widget' => [
                    'type' => 'text',
                    'text' => '$model.provinces_count',
                ]
            ]
        ]
    ]
];
