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
    ],
    'breadcrumbs' => true,
    'components'  => [
        'breadcrumbs' => [
            'view' => 'appshell::widgets.breadcrumbs'
        ]
    ],
    'disable' => [
        'login_counter' => false
    ],
    'ui' => [
        'name'     => 'AppShell',
        'url'      => '/admin/customer',
        'logo_uri' => '/images/appshell/logo.svg',
        'theme'    => 'appshell.default',
        'assets'   => [
            'js'  => \Konekt\AppShell\Assets\DefaultAppShellAssets::JS,
            'css' => \Konekt\AppShell\Assets\DefaultAppShellAssets::CSS
        ],
        'routes' => [
            'login' => 'login',
            'logout' => 'logout',
        ]
    ],
    'avatar' => [
        'gravatar' => [
            'default' => \Konekt\AppShell\Models\GravatarDefault::defaultValue()
        ]
    ]
];
