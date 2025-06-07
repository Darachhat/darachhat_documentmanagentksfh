<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'System Administrator',
            'email' => 'admin@system.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
        ]);

        // Create a sample regular user
        User::create([
            'name' => 'John Doe',
            'email' => 'user@example.com',
            'phone' => '+1234567890',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}
