<?php

namespace App\Observers;

use App\Events\TicketAssigned;
use App\Events\TicketClosed;
use App\Events\TicketCreated;
use App\Ticket;

class TicketObserver
{
    /**
     * Handle the ticket "created" event.
     *
     * @param  \App\Ticket  $ticket
     * @return void
     */
    public function created(Ticket $ticket)
    {
        event(new TicketCreated($ticket, auth()->user()));
    }

    /**
     * Handle the ticket "updated" event.
     *
     * @param  \App\Ticket  $ticket
     * @return void
     */
    public function updated(Ticket $ticket)
    {
        if($ticket->isDirty('closed_at'))
        {
            // This ticket is being closed
            event(new TicketClosed($ticket));
        }
        else if($ticket->isDirty('agent_id') && isset($ticket->agent_id))
        {
            // This ticket is being assigned
            event(new TicketAssigned($ticket));
        }
        else if($ticket->isDirty('agent_id') && empty($ticket->agent_id))
        {
            // This ticket is being un-assigned
        }

    }

    /**
     * Handle the ticket "deleted" event.
     *
     * @param  \App\Ticket  $ticket
     * @return void
     */
    public function deleted(Ticket $ticket)
    {
        //
    }

    /**
     * Handle the ticket "restored" event.
     *
     * @param  \App\Ticket  $ticket
     * @return void
     */
    public function restored(Ticket $ticket)
    {
        //
    }

    /**
     * Handle the ticket "force deleted" event.
     *
     * @param  \App\Ticket  $ticket
     * @return void
     */
    public function forceDeleted(Ticket $ticket)
    {
        //
    }
}
