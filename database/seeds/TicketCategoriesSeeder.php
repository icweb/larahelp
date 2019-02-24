<?php

use Illuminate\Database\Seeder;

class TicketCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'title' => 'Cannot log into my account'
            ],
            [
                'title' => 'Need to reset my password'
            ],
        ];

        foreach($categories as $category)
        {
            \App\TicketCategory::create($category);
        }
    }
}
