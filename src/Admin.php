<?php
namespace Edith\Admin;

use Composer\Autoload\ClassLoader;
use Edith\Admin\Contracts\EdithAuthInterface;
use Edith\Admin\Contracts\EdithModuleCoreInterface;
use Edith\Admin\Support\Composer;
use Edith\Admin\Support\Context;
use Illuminate\Support\Facades\Cache;
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
    const version = '2.0.0';

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
     * @return string
     */
    public function publicKey(): string
    {
        return Cache::remember("edith_public-key", 60 * 60 * 24 * 30, function () {
            return file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'cert' . DIRECTORY_SEPARATOR . 'public_key.pem');
        });
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
            $router->get('edith/micro-apps', 'EdithController@micro')->name('edith.micro');
            // 翼搭云
            $router->post('edith/cloud/register', "EdithController@register")->name("edith.cloud.register");

            $router->apiResource('auth/admin', \AdminController::class);
        });

        app('router')->namespace('Edith\\Admin\\Http\\Controllers')
            ->group(function ($router) {
                $router->get('dashboard/index', 'HomeController@dashboard')->name('dashboard.index');

                $router->apiResources([
                    'auth/menu' => \MenuController::class,
                    'auth/role' => \RoleController::class,
                    'auth/permission' => \PermissionController::class,

                    'system/config' => \SystemController::class,
                    'modules/cloud' => \ModulesController::class,
                ]);
                $router->apiResource('attachments/list', \AttachmentController::class)->only(['index', 'destroy'])->names([
                    'index'   => 'attachments.list.index',
                    'show'    => 'attachments.list.show',
                    'destroy' => 'attachments.list.destroy',
                ]);
                $router->apiResource('attachments/category', \AttachmentCategoryController::class)->names([
                    'index'   => 'attachments.category.index',
                    'store'   => 'attachments.category.store',
                    'show'    => 'attachments.category.show',
                    'update'  => 'attachments.category.update',
                    'destroy' => 'attachments.category.destroy',
                ]);
                // 管理权限
                $router->post('auth/permission/sync', 'PermissionController@sync')->name('permission.sync');
                // 系统配置
                $router->get('system/website', 'SystemController@website')->name('website');
                $router->put('system/website/store', 'SystemController@store')->name('website.store');
                // 操作日志
                $router->get('system/log', 'ActionLogController@index')->name('log');
                // 附件上传
                $router->get('attachments/attachments', 'AttachmentController@attachments')->name('attachments.attachments');
                $router->post('attachments/upload', 'AttachmentController@upload')->name('attachments.upload');
                // 账号配置
                $router->get('account/settings', 'AccountController@index')->name('account.settings');
                $router->post('account/settings', 'AccountController@store')->name('account.settings.store');
            });
    }
}
