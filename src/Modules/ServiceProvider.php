<?php
namespace Edith\Admin\Modules;

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
    }
}