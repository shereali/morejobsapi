<?php

namespace App\Providers;

use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{

    protected $listen = [
        \App\Events\ExampleEvent::class => [
            \App\Listeners\ExampleListener::class,
        ],
        \App\Events\PostCreatedEvent::class => [
            \App\Listeners\PostCreatedEventListener::class,
        ],
    ];

    protected $subscribe = [
        'App\Listeners\AuthEventSubscriber',
    ];
}
