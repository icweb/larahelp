<?php

namespace App\Listeners;

use App\Events\TicketClosed;
use App\Notifications\AgentTicketClosed;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class NotifyAgentsTicketWasClosed
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
        $agents = User::where(['is_agent' => 1])->limit(1)->get();
        Notification::send($agents, new AgentTicketClosed($event->ticket));
    }
}
