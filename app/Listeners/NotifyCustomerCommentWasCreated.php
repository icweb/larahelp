<?php

namespace App\Listeners;

use App\Events\CommentCreated;
use App\Notifications\CustomerCommentCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyCustomerCommentWasCreated
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
        $event->user->notify(new CustomerCommentCreated($event->comment));
    }
}
