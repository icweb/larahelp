<?php

use Illuminate\Database\Seeder;

class TicketPrioritiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $priorities = [
            [
                'title' => 'Low'
            ],
            [
                'title' => 'Medium'
            ],
            [
                'title' => 'High'
            ],
        ];

        foreach($priorities as $priority)
        {
            \App\TicketPriority::create($priority);
        }
    }
}
