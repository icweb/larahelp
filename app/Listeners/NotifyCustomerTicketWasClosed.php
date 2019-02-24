<?php

namespace App\Listeners;

use App\Events\TicketClosed;
use App\Notifications\CustomerTicketClosed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyCustomerTicketWasClosed
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
     * @param  TicketClosed  $event
     * @return void
     */
    public function handle(TicketClosed $event)
    {
        $event->ticket->author->notify(new CustomerTicketClosed($event->ticket));
    }
}
