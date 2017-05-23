<?php

return [
    'modules' => [
        Konekt\Address\Providers\ModuleServiceProvider::class => [],
        Konekt\User\Providers\ModuleServiceProvider::class => []
    ],
    'menu' => [
        'builder' => [
            'class' => \Konekt\AppShell\Menu\MenuBuilder::class
        ],
        'name' => 'appshellMenu'
    ],
    'views' => [
        'namespace' => 'appshell'
    ],
    'routes' => [
        'prefix'     => 'appshell',
        'as'         => 'appshell.',
        'middleware' => ['web', 'auth'],
        'files'      => ['web']
    ],
    'components' => [
        'breadcrumbs' => [
            'view' => 'appshell::widgets.breadcrumbs'
        ]
    ]
];