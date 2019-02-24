<?php

namespace App\Listeners;

use App\Events\TicketWentStale;
use App\Notifications\CustomerTicketStale;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyCustomerTicketIsStale
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TicketWentStale  $event
     * @return void
     */
    public function handle(TicketWentStale $event)
    {
        $event->ticket->author->notify(new CustomerTicketStale($event->ticket));
        $event->ticket->update(['reminded_at' => time()]);
    }
}
