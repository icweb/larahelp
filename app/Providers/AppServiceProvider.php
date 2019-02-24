<?php

namespace App\Providers;

use App\Comment;
use App\Observers\CommentObserver;
use App\Observers\TicketObserver;
use App\Ticket;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Ticket::observe(TicketObserver::class);
        Comment::observe(CommentObserver::class);
    }
}
