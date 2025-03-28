<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Test 1',
            'email' => 'test1@example.com',
            'password' => Hash::make('12345678'),
            'role' => 'resident',

        ]);

        User::factory()->create([
            'name' => 'Test 2',
            'email' => 'test2@example.com',
            'password' => Hash::make('12345678'),
            'role' => 'resident',


        ]);
    }
}
