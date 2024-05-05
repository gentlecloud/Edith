<?php
/*
 |--------------------------------------------------------------------------
 | Gentle Edith Cms configs
 | @Website https://www.gentle.org.cn
 | @Author Gentle Tech
 |--------------------------------------------------------------------------
 */
return [
    'name' => '湛拓 Edith(翼搭) 快速开发框架',
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
                'model'  => Gentle\Edith\Models\EdithAdmin::class,
            ],
        ],

        // Redirect to the specified URI when user is not authorized.
        'redirect_to' => 'auth/login',

        // The URIs that should be excluded from authorization.
        'excepts' => [
            'api/'.config('newly.route.prefix','newly').'/auth/login',
            'api/'.config('newly.route.prefix','newly').'/auth/query',
            'api/'.config('newly.route.prefix','newly').'/auth/captcha'
        ],

        'semi_permissions' => [
            'api/'.config('newly.route.prefix','newly').'/auth/info',
            'api/'.config('newly.route.prefix','newly').'/ui/layout',
            'api/'.config('newly.route.prefix','newly').'/ui/menus',
            'api/'.config('newly.route.prefix','newly').'/auth/logout',
        ],

        'admin_id' => 1, // 超级管理员ID
        'fail_num' => 5, // 最大登录失败次数，超过失败次数禁止登录 10 分钟
    ],

    /*
    |--------------------------------------------------------------------------
    | Newly-Cms route settings
    |--------------------------------------------------------------------------
    |
    | The routing configuration of the admin page, including the path prefix,
    | the controller namespace, and the default middleware. If you want to
    | access through the root path, just set the prefix to empty string.
    |
    */
    'route' => [
        'prefix' => env('NEWLY_MANAGE_ROUTE_PREFIX', 'newly'),
        'namespace' => 'App\\Newly\\Controllers',
        'middleware' => ['edith.auth'],
    ],

    /*
     |------------------------------------------------------------------------------
     | Newly Module settings
     |------------------------------------------------------------------------------
     |
     | The Module packages Powered by nWidart/laravel-modules
     | Newly-Cms uses the above package for secondary integration development
     | Thank you again for the high quality open source project provided by nwidart
     |
     */
    'modules' => [
        'namespace' => 'Module', // Newly Module namespace

        'paths' => base_path('module'), // Newly Module Base Path

        'assets' => public_path('module'), // Newly Module Assets Base Path

        'cache' => [
            'enabled' => false,
            'key' => 'newly-modules',
            'lifetime' => 60,
        ],

        'scan' => [
            'enabled' => false,
            'paths' => [
                base_path('vendor/*/*'),
            ],
        ],

        'composer' => [
            'composer-output' => false,
        ],

        'register' => [
            'translations' => true,
            'files' => 'register',
        ],

        'activators' => [
            'file' => [
                'class' => \Gentle\Edith\Modules\Activators\FileActivator::class,
                'statuses-file' => base_path('newly_modules.json'),
                'cache-key' => 'activator.installed',
                'cache-lifetime' => 604800,
            ],
            'boot' => [

            ]
        ],

        'activator' => 'file',
    ],

    /*
    |--------------------------------------------------------------------------
    | Expiration Minutes
    |--------------------------------------------------------------------------
    |
    | This value controls the number of minutes until an issued token will be
    | considered expired. If this value is null, personal access tokens do
    | not expire. This won't tweak the lifetime of first-party sessions.
    |
    */

    'expiration' => null,

    // 前端头部行为
    'header_actions' => [],
    'newly_ui' => 'https://cdn.ichuchuang.cn/ui/newlyadmin',
    'newly_api' => 'https://gateway.newly.cc/api/'
];

