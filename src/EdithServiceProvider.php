<?php
namespace Gentle\Edith;

use Gentle\Edith\Contracts\EdithAuthInterface;
use Gentle\Edith\Contracts\EdithPlatformInterface;
use Gentle\Edith\Core\Auth;
use Gentle\Edith\Core\Platform;
use Gentle\Edith\Support\Database\Helper;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

/**
 * Edith Service Provider
 * 湛拓科技 - 翼搭(Edith) Cms 服务提供者
 * @author Chico Written in Xiamen on 2022.11.30, Xiamen Gentle Technology Co., Ltd
 * @copyright 2021-2038 Xiamen Gentle Technology Co., Ltd
 */
class EdithServiceProvider extends ServiceProvider
{
    /**
     * The application's Command
     * @var array
     */
    protected array $commands = [
        Console\InstallCommand::class,
        Console\PublishCommand::class,
//        Console\UpdateCommand::class,
    ];

    /**
     * The application's route middleware.
     * @var array
     */
    protected array $routeMiddleware = [
        'edith.auth' => Http\Middleware\Authenticate::class,
        'edith.log' => Http\Middleware\LogOperation::class
    ];

    /**
     * The application's route middleware groups.
     * @var array
     */
    protected array $middlewareGroups = [
        'edith' => [
            'edith.auth',
            'edith.log'
        ]
    ];

    /**
     * The application's providers
     * @var array
     */
    protected array $providers = [
        Providers\EventServiceProvider::class,
    ];

    /**
     * @return void
     */
    public function boot()
    {
        if (env('APP_DEBUG') == true) {
            Helper::listen();
        }
    }

    /**
     * Register services.
     * @return void
     */
    public function register()
    {
        // 加载权限设置
        $this->loadAdminAuthConfig();
        // 注册服务提供
        $this->registerProviders();
        $this->registerPublishing();
        // 管理路由
        $this->registerRoutes();
        $this->registerRouteMiddleware();
        // 湛拓（Edith）相关服务注册
        $this->registerServices();
        // 注册 翼搭（Edith）框架 相关服务任务
        $this->commands($this->commands);
    }

    /**
     * 资源发布注册.
     *
     * @return void
     */
    protected function registerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__.'/../config' => config_path()], 'edith-config');
            $this->publishes([__DIR__.'/../database/migrations' => database_path('migrations')], 'edith-migrations');
            $this->publishes([__DIR__.'/../resources/lang' => resource_path('lang')], 'edith-resources-lang');
            $this->publishes([__DIR__.'/../resources/views' => resource_path('views/admin')], 'edith-resources-views');
        }
    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    protected function registerRoutes()
    {
        if (file_exists(base_path('/routes/edith.php'))) {
            $this->registerEdithRoutes();
        }
    }

    /**
     * Register Manage Router Default manage
     * 载入管理路由
     */
    protected function registerEdithRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->group(base_path('/routes/edith.php'));
    }

    /**
     * Register the route middleware.
     * 载入中间件
     * @return void
     */
    protected function registerRouteMiddleware()
    {
        // register route middleware.
        foreach ($this->routeMiddleware as $key => $middleware) {
            app('router')->aliasMiddleware($key, $middleware);
        }

        // register middleware group.
        foreach ($this->middlewareGroups as $key => $middleware) {
            app('router')->middlewareGroup($key, $middleware);
        }
    }

    /**
     * register Gentle Application Services
     */
    protected function registerServices() {
        // 管理员鉴权
        $this->app->singleton('edith.auth', EdithAuthInterface::class);
        $this->app->bind(EdithAuthInterface::class, function() {
            return new Auth;
        });
    }

    /**
     * Force to set https scheme if https enabled.
     * 设置HTTPS
     */
    protected function setHttps(){
        if (env('WEB_SITE_SSL', false) !== false) {
            url()->forceScheme('https');
            $this->app['request']->server->set('HTTPS', true);
        }
    }

    /**
     * Setup auth configuration.
     * 载入鉴权
     * @return void
     */
    protected function loadAdminAuthConfig()
    {
        config(Arr::dot(config('edith.auth', []), 'auth.'));
    }

    /**
     * Register the providers
     * @return void
     */
    protected function registerProviders()
    {
        foreach ($this->providers as $provider) {
            $this->app->register($provider);
        }
    }
}