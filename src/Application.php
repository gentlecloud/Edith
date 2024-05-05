<?php
namespace Gentle\Edith;

/**
 * Edith Application
 * 湛拓科技 - 翼搭 Laravel 快速开发应用包
 * @author Chico Written in Xiamen on 2022.11.30, Xiamen Gentle Technology Co., Ltd
 * @copyright Xiamen Gentle Technology Co., Ltd
 */
class Application
{

    /**
     * edith router prefix
     * @return string
     */
    public function routerPrefix(): string
    {
        return config('edith.route.prefix', 'edith');
    }

    /**
     * Loader Edith Routers
     * 2021.05.05 22:30:00
     * @author Chico, Gentle
     */
    public function routes()
    {
        $prefix = $this->routerPrefix();
        // 翼搭框架相关路由
        $attributes = [
            'namespace' => config('edith.route.namespace', 'App\\Edith\\Controllers'),
            'middleware' => config('edith.route.middleware', ['edith.auth', 'edith.log'])
        ];

        app('router')->group($attributes, function ($router) {
            $router->get('edith/_routes', 'App\Edith\Controllers\EdithController@routes')->name("api/edith/_routes");

            $router->get('edith/auth/login', 'AuthController@login')->name("api/edith/auth/login");
            $router->post('edith/auth/login', 'AuthController@toLogin')->name("api/edith/auth/login");
            $router->post('edith/auth/logout', 'AuthController@logout')->name("api/edith/auth/logout");
            $router->get('edith/auth/query', 'AuthController@query')->name("api/edith/auth/query");
            $router->get('edith/auth/info', 'AuthController@info')->name("api/edith/auth/info");
            $router->get('edith/auth/menu', 'AuthController@menu')->name("api/edith/auth/menu");
            $router->post('edith/auth/platform', 'AuthController@platform')->name('api/edith/auth/platform');
            $router->get('edith/manage', 'EdithController@manage')->name('api/edith/manage');

            $router->get('dashboard/index', 'EdithController@dashboard')->name('api/dashboard/index');

            $router->resource('auth/admin', \AdminController::class);

        });

        app('router')->middleware(config('edith.route.middleware', ['edith.auth', 'edith.log']))
            ->namespace('Gentle\\Edith\\Http\\Controllers')
            ->group(function ($router) {
                $router->resources([
                    'auth/menu' => \MenuController::class,
                    'auth/role' => \RoleController::class,

                    'system/config' => \SystemController::class,
                    'attachments/list' => \AttachmentController::class,
                    'platforms/list' => \PlatformController::class,
                    'finances/payment' => \PaymentController::class,
                ]);
                // 管理权限
                $router->get('auth/permission', 'PermissionController@index');
                $router->put('auth/permission/:id', 'PermissionController@update');
                $router->post('auth/permission/sync', 'PermissionController@sync');
                // 系统配置
                $router->get('system/website', 'SystemController@website')->name('api/system/website');
                $router->put('system/save', 'SystemController@save')->name('api/system/save');
                // 操作日志
                $router->get('system/actionLog/index', 'ActionLogController@index')->name('api/system/actionLog/index');
                // 支付证书上传
                $router->post('finances/payment/upload', 'PaymentController@upload')->name('api/finances/payment/upload');
                // 附件上传
                $router->get('attachment/attachments', 'AttachmentController@attachments')->name('api/attachment/attachments');
                $router->post('attachment/upload', 'AttachmentController@upload')->name('api/attachment/upload');
                // 账号配置
                $router->get('account/settings', 'AccountController@index')->name('api/account/settings');
                $router->post('account/settings', 'AccountController@store')->name('api/account/settings');
            });
    }
}
