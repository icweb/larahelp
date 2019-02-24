<?php

namespace App\Console\Commands;

use App\Ticket;
use Illuminate\Console\Command;

class CheckForStaleTickets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tickets:stale';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks for tickets open longer than 3 days';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Ticket::checkForStaleTickets();
    }
}
