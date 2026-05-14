<?php
namespace Edith\Admin\Modules;

use Edith\Admin\Modules\Middleware\Cloud;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    /**
     * Booting the package.
     */
    public function boot(): void
    {
        $this->app['edith.modules']->boot();
    }

    /**
     * Register the provider.
     */
    public function register(): void
    {
        $this->app['edith.modules']->register();
        $this->registerRoutes();
    }

    protected function registerRoutes()
    {
        Route::prefix('gwapi')
            ->middleware(['api', Cloud::class, 'edith.log:翼搭云'])
            ->group(function ($router) {
                $router->post('dock', 'Edith\Admin\Modules\Controllers\CloudController@dock')->name('gwapi.dock');
                $router->post('register', 'Edith\Admin\Modules\Controllers\CloudController@register')->name('gwapi.register');
                $router->post('modules', 'Edith\Admin\Modules\Controllers\CloudController@modules')->name('gwapi.modules');
            });
    }
}