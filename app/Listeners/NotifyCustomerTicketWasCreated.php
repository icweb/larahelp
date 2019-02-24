<?php

namespace App\Listeners;

use App\Events\TicketCreated;
use App\Notifications\CustomerTicketCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyCustomerTicketWasCreated
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
     * @param  TicketCreated  $event
     * @return void
     */
    public function handle(TicketCreated $event)
    {
        $event->user->notify(new CustomerTicketCreated($event->ticket));
    }
}
