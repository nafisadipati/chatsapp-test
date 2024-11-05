<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'User One',
            'email' => 'user1@example.com',
            'password' => bcrypt('password123'),
        ]);

        User::create([
            'name' => 'User Two',
            'email' => 'user2@example.com',
            'password' => bcrypt('password123'),
        ]);

        User::create([
            'name' => 'User Three',
            'email' => 'user3@example.com',
            'password' => bcrypt('password123'),
        ]);

        User::create([
            'name' => 'User Four',
            'email' => 'user4@example.com',
            'password' => bcrypt('password123'),
        ]);
    }
}
