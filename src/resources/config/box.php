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
    ]
];