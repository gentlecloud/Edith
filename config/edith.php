<?php
/*
 |--------------------------------------------------------------------------
 | Edith configs
 | @Website https://www.ieda.cc
 | @Author Gentle Tech
 |--------------------------------------------------------------------------
 */
return [
    'name' => '翼搭（Edith）',
    'title' => '翼搭（Edith）极速开发框架',
    /*
    |--------------------------------------------------------------------------
    | Edith auth setting
    |--------------------------------------------------------------------------
    |
    | Authentication settings for all admin pages. Include an authentication
    | guard and a user provider setting of authentication driver.
    |
    | You can specify a controller for `login` `logout` and other auth routes.
    |
    */
    'auth' => [
        'guards' => [
            'manage' => [
                'driver'   => 'session',
                'provider' => 'manage',
            ],
        ],

        'providers' => [
            'manage' => [
                'driver' => 'eloquent',
                'model'  => \Edith\Admin\Models\EdithAdmin::class,
            ],
        ],

        // Redirect to the specified URI when user is not authorized.
        'redirect_to' => 'edith/auth/login',

        // The URIs that should be excluded from authorization.
        'excepts' => [
            'edith._routes',
            'edith.init',
            'edith.manage',
            'edith.auth.captcha',
            'edith.auth.query',
            'edith.auth.login',
            'edith.micro'
        ],

        'semi_permissions' => [
            'edith.auth.info',
            'edith.auth.logout',
            'edith.auth.platform',
            'edith.auth.menu',
            'dashboard.index'
        ],

        'admin_id' => 1, // 超级管理员ID
        'fail_num' => 5, // 最大登录失败次数，超过失败次数禁止登录 10 分钟
    ],

    /*
    |--------------------------------------------------------------------------
    | Edith-Admin route settings
    |--------------------------------------------------------------------------
    |
    | The routing configuration of the admin page, including the path prefix,
    | the controller namespace, and the default middleware. If you want to
    | access through the root path, just set the prefix to empty string.
    |
    */
    'route' => [
        'prefix' => env('EDITH_MANAGE_ROUTE_PREFIX', 'edith'),
        'namespace' => 'App\\Edith\\Controllers',
        'middleware' => ['api', 'edith.admin'],
    ],

    'modules' => [
        'path' => base_path('modules'),
        'namespace' => 'Modules\\'
    ],

    'ui' => [
        'version' => '1.0.0',
    ],

    'rsa' => [
        'public_key' => "",
        'private_key' => ''
    ]
];