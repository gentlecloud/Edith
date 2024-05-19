<?php
namespace Edith\Admin;

use Composer\Autoload\ClassLoader;
use Edith\Admin\Contracts\EdithAuthInterface;
use Edith\Admin\Contracts\EdithModuleCoreInterface;
use Edith\Admin\Support\Composer;
use Edith\Admin\Support\Context;
use Illuminate\Support\Facades\Schema;

/**
 * Edith Admin
 * 湛拓科技 - 翼搭 Laravel 快速开发应用包
 * @author Chico Written in Xiamen on 2022.11.30, Xiamen Gentle Technology Co., Ltd
 * @copyright Xiamen Gentle Technology Co., Ltd
 */
class Admin
{
    /**
     * Edith version
     */
    const version = 'v1.0.3';

    /**
     * load current Composer
     * @return ClassLoader
     */
    public function classLoader(): ClassLoader
    {
        return Composer::loader();
    }

    /**
     * edith router prefix
     * @return string
     */
    public function routerPrefix(): string
    {
        return config('edith.route.prefix', 'edith');
    }

    /**
     * @return string
     */
    public function version(): string
    {
        return self::version;
    }

    /**
     * @return EdithAuthInterface
     */
    public function auth(): EdithAuthInterface
    {
        return app('edith.auth');
    }

    /**
     * 上下文管理
     * @return Context
     */
    public function context(): Context
    {
        return app('edith.context');
    }

    /**
     * @return EdithModuleCoreInterface
     */
    public function modules(): EdithModuleCoreInterface
    {
        return app('edith.modules');
    }

    /**
     * @param string $tableName
     * @return bool
     */
    public function hasTable(string $tableName): bool
    {
        return Schema::hasTable($tableName);
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

        app('router')->namespace(config('edith.route.namespace', 'App\\Edith\\Controllers'))->group(function ($router) {
            $router->get('edith/_routes', 'App\Edith\Controllers\EdithController@routes')->name("edith._routes");

            $router->get('edith/auth/login', 'AuthController@login')->name("edith.auth.login");
            $router->post('edith/auth/login', 'AuthController@toLogin')->name("edith.auth.login");
            $router->get('edith/auth/captcha', 'AuthController@captcha')->name("edith.auth.captcha");
            $router->post('edith/auth/logout', 'AuthController@logout')->name("edith.auth.logout");
            $router->get('edith/auth/query', 'AuthController@query')->name("edith.auth.query");
            $router->get('edith/auth/info', 'AuthController@info')->name("edith.auth.info");
            $router->get('edith/auth/menu', 'AuthController@menu')->name("edith.auth.menu");
            $router->get('edith/manage', 'EdithController@manage')->name('edith.manage');

            $router->get('dashboard/index', 'EdithController@dashboard')->name('dashboard.index');

            $router->apiResource('auth/admin', \AdminController::class);

        });

        app('router')->namespace('Edith\\Admin\\Http\\Controllers')
            ->group(function ($router) {
                $router->apiResources([
                    'auth/menu' => \MenuController::class,
                    'auth/role' => \RoleController::class,

                    'system/config' => \SystemController::class,
                    'modules/cloud' => \ModulesController::class,
                    'attachments/list' => \AttachmentController::class,
                    'attachments/category' => \AttachmentCategoryController::class
                ]);
                // 管理权限
                $router->get('auth/permission', 'PermissionController@index')->name('permission.index');
                $router->put('auth/permission/{permission}', 'PermissionController@update')->name('permission.update');
                $router->post('auth/permission/sync', 'PermissionController@sync')->name('permission.sync');
                $router->delete('auth/permission/{permission}', 'PermissionController@destroy')->name('permission.destroy');
                // 系统配置
                $router->get('system/website', 'SystemController@website')->name('website');
                $router->put('system/website/store', 'SystemController@store')->name('website.store');
                // 操作日志
                $router->get('system/log', 'ActionLogController@index')->name('log');
                // 附件上传
                $router->get('attachments/attachments', 'AttachmentController@attachments')->name('attachments.attachments');
                $router->post('attachments/upload', 'AttachmentController@upload')->name('attachments.upload');
                // 账号配置
                $router->get('account/settings', 'AccountController@index')->name('settings.index');
                $router->post('account/settings', 'AccountController@store')->name('settings.store');
            });
    }
}
