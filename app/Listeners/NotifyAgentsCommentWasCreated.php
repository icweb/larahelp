<?php

namespace App\Listeners;

use App\Events\CommentCreated;
use App\Notifications\AgentCommentCreated;
use App\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyAgentsCommentWasCreated
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
     * @param  CommentCreated  $event
     * @return void
     */
    public function handle(CommentCreated $event)
    {
        $agents = User::where(['is_agent' => 1])->limit(1)->get();
        Notification::send($agents, new AgentCommentCreated($event->comment));
    }
}
