<?php

return [
    'modules' => [
        Konekt\Address\Providers\ModuleServiceProvider::class => [],
        Konekt\Customer\Providers\ModuleServiceProvider::class => [],
        Konekt\User\Providers\ModuleServiceProvider::class => [],
        Konekt\Acl\Providers\ModuleServiceProvider::class => []
    ],
    'event_listeners' => true,
    'menu' => [
        'appshell' => [
            'share'          => 'appshellMenu',
            'cascade_data'   => false,
            'active_element' => 'link'
        ]
    ],
    'views' => [
        'namespace' => 'appshell'
    ],
    'routes' => [
        'prefix'     => 'appshell',
        'as'         => 'appshell.',
        'middleware' => ['web', 'auth', 'acl'],
        'files'      => ['web']
    ],
    'breadcrumbs' => true,
    'components' => [
        'breadcrumbs' => [
            'view' => 'appshell::widgets.breadcrumbs'
        ]
    ],
    'ui' => [
        'name' => 'AppShell',
        'url'  => '/appshell/dashboard'
    ]
];