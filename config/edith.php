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
            'api/edith/_routes',
            'api/edith/init',
            'api/edith/manage',
            'api/edith/auth/captcha',
            'api/edith/auth/query',
            'api/edith/auth/login',
        ],

        'semi_permissions' => [
            'api/edith/auth/info',
            'api/edith/auth/logout',
            'api/edith/auth/platform',
            'api/edith/auth/menu'
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
        'middleware' => ['edith.auth', 'edith.log'],
    ],

    'rsa' => [
        'public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAoOyoxDRR4XawjfZ3Kkw9CRcsq+NJ1A1Tt6dY8BvvjMVGZhVLv+Vz1q4y+TiaPIGHAXR2Y7DWCu/ZR1lL9Ga0KddrM4W46pAUBiI44/jZh2IGNx5zLwJnx4Mo1edLiB/1ZYpnCuS4XPULJMX2Vlm2B8dZdIA5qoB8Omkl0ZAA65KweUhiMxtrGkqq03ET6eq6dEV8/4nX412nqiEDVIFDiuPJ1Jb0tpkvh02zKEs4eh8cZAClTHSMApHRf+qL2QBc45PKI64BFyYc5rdjKAF2oD4sTMxJuJQ24/XAExludMK1tJxYCmwFL6uDWMgk6GfRU5DiyI0L0V4hbQAvdzBjtQIDAQAB",
        'private_key' => 'MIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQCg7KjENFHhdrCN9ncqTD0JFyyr40nUDVO3p1jwG++MxUZmFUu/5XPWrjL5OJo8gYcBdHZjsNYK79lHWUv0ZrQp12szhbjqkBQGIjjj+NmHYgY3HnMvAmfHgyjV50uIH/VlimcK5Lhc9QskxfZWWbYHx1l0gDmqgHw6aSXRkADrkrB5SGIzG2saSqrTcRPp6rp0RXz/idfjXaeqIQNUgUOK48nUlvS2mS+HTbMoSzh6HxxkAKVMdIwCkdF/6ovZAFzjk8ojrgEXJhzmt2MoAXagPixMzEm4lDbj9cATGW50wrW0nFgKbAUvq4NYyCToZ9FTkOLIjQvRXiFtAC93MGO1AgMBAAECggEASEbi6fTBze0cETbggMvrIfkZpD4ae7ZcooD0Liut5OD55IGuGws4gvSMimkExSY798hSICZdjF37jdMqjSPPyXcqe+KUki2SAMtAGAw9z1OUjQ8NFtESwYZEQgZ3YzVPZ4LJExh1QbMBhUuwf0odutKrd+rbe5vnr+hoBv6Rmzv4N6OZ8jImSYb5pQJoK4Ykeruv10wJgCuxxccun7lFxbeioRZQkFkcKdi6CrRrQiej2AbbWeBbPmgyOIkMe0oMNi3ymSyAxWrO2bbejHT+hKbcfsgJD27hYeJbI9QsskQdC4oiIOh6OjTLFopzVyam87bTdJvZPy1EnSjd7FvAQQKBgQDoBlgM3PhrN6bD0eyfqqyXXY1tFVc6AiCX+o3S47As1bw0Cq88KYeeA9xyK075pV+wNY6XOld+IkXicDUDbCb9aa6DFf50qWdT07rC0E3Xn8bkg8eeFuFTabRY4WdJWV6AU3nvl4GK13vw3PLqzBtNOSzimeHP/ErMEeQpYztaMQKBgQCxjYcKcn9KDqd1P2NpgbZQYDMYcCtbO1+2DJLhnpLAhyJzZxSF2YcmLru6dRAF5QeXZEQWXIdXPQ5uVCuqdnseKKMPPjBRl+LyHr00X6Msz8R1G+xhd5Z6BuPtF/DhqCxsI7sq0heQCbGtvw6aXXmpdD4bGJw9umNkbtkHbsi8xQKBgE3lI1ZeMQA91LzVEy2fbQX8IGjIy1nsMOkU8twkGJdUwjRuidoWzzLbdPzXUVI6lN9he5eFvK3Z78BPj1ywyH43JqFXlu+vl8LqyD5zFE8ZkvpQy4llgQwx5pwYQEa9vB406DDpmlH0eeWpJ9xv3ZKVaV5B7y+WMb5FG2ZRrDFhAoGANH2h0b3d0dgZO7l8u2Fks8hs8qmet78K4bg/6EHIIvEQh0uPLq8LnIcuasZW8VcvcltrIa1DOdBMJuPtcNzMMzNSWZxKDqU3q9rYltY7WHEoJHMX5AzFyNempJ5yUVQ1pda+a79mxeeHxtT4DTzbTfSWs84HytwCrFt1ABSJdf0CgYAmyCenrDhMZRJ6z3APioFEmRBAiuEmVYGxlQuN49ZnwPQO9La04KPW0+HfjcFt/PNMfpoB8rK2BPpi9EJNM8UOJdWdUq0PiNYFDFHYAZ3OLp9Je5kuGiskbq9vIHkKXKw4QmbyJN9RRoRotavhk/wcpbNwV4qk0VWINltWGKKvUQ=='
    ]
];

