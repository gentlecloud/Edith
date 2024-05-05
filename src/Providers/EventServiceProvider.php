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
        \Gentle\Edith\Events\AuthLoginAfter::class => [
            \Gentle\Edith\Listeners\AuthLoginAfter::class
        ],
        \Gentle\Edith\Events\ConfigRendererAfter::class => [
            \Gentle\Edith\Listeners\ConfigRendererAfter::class
        ],
        \Gentle\Edith\Events\UploadAfter::class => [
            \Gentle\Edith\Listeners\UploadAfter::class
        ],
        \Gentle\Edith\Events\PaymentConfigBefore::class => [
            \Gentle\Edith\Listeners\PaymentConfigBefore::class
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