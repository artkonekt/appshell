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
        'prefix'     => 'admin',
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
        'url'  => '/admin/customer',
        'assets' => [
            'js' => [
                'js/appshell.js'
            ],
            'css' => [
                'https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i',
                'css/appshell.css',
                'https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css' => [
                    'integrity' => 'sha256-3sPp8BkKUE7QyPSl6VfBByBroQbKxKG7tsusY2mhbVY=',
                    'crossorigin' => 'anonymous'
                ]
            ]
        ]
    ],
    'avatar' => [
        'gravatar' => [
            'default' => \Konekt\AppShell\Models\GravatarDefault::defaultValue()
        ]
    ]
];
