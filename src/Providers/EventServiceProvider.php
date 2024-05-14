<?php
namespace Edith\Admin\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as BaseServiceProvider;

class EventServiceProvider extends BaseServiceProvider
{
    /**
     * The event listener mappings for the application.
     * @var array
     */
    protected $listen = [
        \Edith\Admin\Events\AuthLoginBefore::class => [
            \Edith\Admin\Listeners\AuthLoginBefore::class
        ],
        \Edith\Admin\Events\AuthLoginAfter::class => [
            \Edith\Admin\Listeners\AuthLoginAfter::class
        ],
        \Edith\Admin\Events\UploadAfter::class => [
            \Edith\Admin\Listeners\UploadAfter::class
        ]
    ];

    /**
     * The event subscribe mappings for the application.
     * @var array
     */
    protected $subscribe = [];

    /**
     * Register any events for your application.
     * @return void
     */
    public function boot()
    {
        //
    }
}