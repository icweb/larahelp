<?php

namespace App;

use App\Events\TicketWentStale;
use Illuminate\Database\Eloquent\Model;

class Ticket extends BaseClass
{
    protected $fillable = [
        'agent_id',
        'category_id',
        'priority_id',
        'subject',
        'body',
        'closed_at',
        'reminded_at',
    ];

    protected $dates = [
        'closed_at',
        'reminded_at',
    ];

    public function scopeMine($query)
    {
        if(auth()->user()->is_agent)
        {
           return $query;
        }

        return $query->where('author_id', auth()->id());
    }

    public function scopeStatus($query, $status)
    {
        if($status === 'all')
        {
            return $query;
        }
        else if($status === 'closed')
        {
            return $query->whereNotNull('closed_at');
        }
        else if($status === 'open')
        {
            return $query->whereNull('closed_at');
        }
    }

    public function scopeStale($query)
    {
        return $query->with(['comments' => function ($query) {

                $query->orderBy('id', 'desc');

            }, 'comments.author'])
            ->has('comments')
            ->where('reminded_at', '<', strtotime('+ 3 days'))
            ->orWhereNull('reminded_at');
//            ->where(function($query){
//
//                $query;
//                   // ;;
//
//            });
    }

    public static function checkForStaleTickets()
    {
        $open_tickets = Ticket::status('open')
            ->whereNotNull('agent_id')
            ->get();

        foreach($open_tickets as $open_ticket)
        {
            Comment::checkForStale($open_ticket);
        }
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function priority()
    {
        return $this->belongsTo(TicketPriority::class);
    }

    public function category()
    {
        return $this->belongsTo(TicketCategory::class);
    }

    public function agent()
    {
        return $this->belongsTo(User::class);
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }
}
