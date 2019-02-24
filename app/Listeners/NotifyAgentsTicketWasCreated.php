<?php

namespace App\Listeners;

use App\Events\TicketCreated;
use App\Notifications\AgentTicketCreated;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class NotifyAgentsTicketWasCreated
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
        $agents = User::where(['is_agent' => 1])->limit(1)->get();
        Notification::send($agents, new AgentTicketCreated($event->ticket));
    }
}
