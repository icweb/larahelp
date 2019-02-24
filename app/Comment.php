<?php

namespace App;

use App\Events\TicketWentStale;
use Illuminate\Database\Eloquent\Model;

class Comment extends BaseClass
{
    protected $fillable = [
        'ticket_id',
        'is_internal',
        'body',
    ];

    public function scopeVisible($query)
    {
        if(auth()->user()->is_agent)
        {
            return $query;
        }
        else
        {
            return $query->where('is_internal', 0);
        }
    }

    public static function checkForStale(Ticket $ticket)
    {
        if(
            empty($ticket->reminded_at)
            || strtotime($ticket->reminded_at) < strtotime('+ 3 days')
        )
        {
            $last_comment = $ticket->comments()->orderBy('id', 'desc')->first();

            if(
                isset($last_comment->id)
                && $last_comment->author->is_agent > 0
                && strtotime($last_comment->created_at) < strtotime('- 3 days')
            )
            {
                info('ticket is stale');
                event(new TicketWentStale($last_comment->ticket));
            }
            else
            {
                info('ticket is not stale');
            }
        }
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
