<?php

return [
    'modules' => [
        Konekt\Address\Providers\ModuleServiceProvider::class  => [],
        Konekt\Customer\Providers\ModuleServiceProvider::class => [],
        Konekt\User\Providers\ModuleServiceProvider::class     => [],
        Konekt\Acl\Providers\ModuleServiceProvider::class      => []
    ],
    'acl' => [
        'allow_action_as_verb' => false
    ],
    'event_listeners' => true,
    'menu'            => [
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
        [
            'prefix'     => 'admin',
            'as'         => 'appshell.',
            'middleware' => ['web', 'auth', 'acl'],
            'files'      => ['acl']
        ],
        [
            'prefix'     => 'admin',
            'as'         => 'appshell.',
            'middleware' => ['web', 'auth'],
            'files'      => ['nonacl']
        ],
        [
            'prefix'     => 'pub',
            'as'         => 'appshell.public.',
            'middleware' => ['web'],
            'files'      => ['public']
        ],
    ],
    'breadcrumbs' => true,
    'disable' => [
        'login_counter' => false,
        'commands' => false,
    ],
    'ui' => [
        'name'       => 'AppShell',
        'url'        => '/admin/customer',
        'logo_uri'   => '/images/appshell/logo.svg',
        'theme'      => 'appshell',
        'icon_theme' => 'zmdi',
        'routes' => [
            'login'            => 'login',
            'logout'           => 'logout',
            'register'         => 'register',
            'password.request' => 'password.request',
            'password.email'   => 'password.email',
        ],
        'quick_links' => [
            'enabled' => true
        ]
    ],
    'formats'   => [
        'date' => [
            'default' => 'Y-m-d',
            'options' => [
                'Y-m-d',
                'd.m.Y',
                'm/d/Y',
                'M j, Y',
                'diff'
            ]
        ],
        'datetime' => [
            'default' => 'Y-m-d H:i',
            'options' => [
                'Y-m-d H:i',
                'd.m.Y H:i',
                'd.m.Y h:iA',
                'm/d/Y H:i',
                'm/d/Y h:ia',
                'M j, Y H:i',
                'M j, Y h:ia',
                'diff'
            ]
        ],
        'time'=> [
            'default' => 'H:i',
            'options' => [
                'H:i',
                'G:i',
                'h:iA',
                'h:ia',
                'g:iA',
                'g:ia',
                'diff'
            ]
        ],
    ],
    'avatar' => [
        'gravatar' => [
            'default' => \Konekt\AppShell\Models\GravatarDefault::defaultValue()
        ]
    ]
];
