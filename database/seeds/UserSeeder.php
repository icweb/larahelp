<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'is_agent' => 0,
                'name' => 'Customer',
                'email' => 'customer@mail.com',
                'password' => bcrypt('password')
            ],
            [
                'is_agent' => 1,
                'name' => 'Agent',
                'email' => 'agent@mail.com',
                'password' => bcrypt('password')
            ],
        ];

        foreach($users as $user)
        {
            \App\User::create($user);
        }
    }
}
