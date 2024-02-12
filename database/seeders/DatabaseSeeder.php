<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         \App\Models\User::factory(1)->create([
            'name' => 'Test User',
            'email' => 'admin@mail.com',
             'password' => bcrypt('1234567890'),
         ]);
    }
}
