<?php
namespace Gentle\Edith\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as BaseServiceProvider;

class EventServiceProvider extends BaseServiceProvider
{
    /**
     * The event listener mappings for the application.
     * @var array
     */
    protected $listen = [
        \Gentle\Edith\Events\AuthLoginBefore::class => [
            \Gentle\Edith\Listeners\AuthLoginBefore::class
        ],
        \Gentle\Edith\Events\AuthLoginAfter::class => [
            \Gentle\Edith\Listeners\AuthLoginAfter::class
        ],
        \Gentle\Edith\Events\UploadAfter::class => [
            \Gentle\Edith\Listeners\UploadAfter::class
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