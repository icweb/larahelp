<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        'App\Events\TicketCreated' => [
            'App\Listeners\NotifyCustomerTicketWasCreated',
            'App\Listeners\NotifyAgentsTicketWasCreated',
        ],
        'App\Events\CommentCreated' => [
            'App\Listeners\NotifyCustomerCommentWasCreated',
            'App\Listeners\NotifyAgentsCommentWasCreated',
        ],
        'App\Events\TicketClosed' => [
            'App\Listeners\NotifyCustomerTicketWasClosed',
            'App\Listeners\NotifyAgentsTicketWasClosed',
        ],
        'App\Events\TicketAssigned' => [
            'App\Listeners\NotifyCustomerTicketWasAssigned',
            'App\Listeners\NotifyAgentsTicketWasAssigned',
        ],
        'App\Events\TicketWentStale' => [
            'App\Listeners\NotifyCustomerTicketIsStale'
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
