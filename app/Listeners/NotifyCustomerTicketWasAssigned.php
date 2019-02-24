<?php

namespace App\Listeners;

use App\Events\TicketAssigned;
use App\Notifications\CustomerTicketAssigned;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyCustomerTicketWasAssigned
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
     * @param  TicketAssigned  $event
     * @return void
     */
    public function handle(TicketAssigned $event)
    {
        $event->ticket->author->notify(new CustomerTicketAssigned($event->ticket));
    }
}
