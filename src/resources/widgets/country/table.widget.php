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
            'is_eu_member' => [
                'title' => __('EU Member'),
                'valign' => 'middle',
                'widget' => [
                    'type' => 'badge',
                    'color' => ['bool' => ['success', 'secondary']],
                    'text' => '$model.is_eu_member',
                    'modifier' => sprintf('bool2text:%s,%s', __('Yes'), __('No')),
                ],
            ],
        ]
    ]
];
