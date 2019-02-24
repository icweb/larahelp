<?php

namespace App\Listeners;

use App\Events\TicketAssigned;
use App\Notifications\AgentTicketAssigned;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class NotifyAgentsTicketWasAssigned
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
        $agents = User::where(['is_agent' => 1])->limit(1)->get();
        Notification::send($agents, new AgentTicketAssigned($event->ticket));
    }
}
