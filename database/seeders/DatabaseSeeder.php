<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Recipe;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'id' => 1,
            'name' => 'Admin',
            'email' => 'admin123@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'foto' => '',
        ]);
        User::create([
            'name' => 'User',
            'email' => 'user123@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('user123'),
            'role' => 'user',
            'foto' => '',
        ]);

        // User::factory()->count(100)->create();
        // Recipe::factory()->count(100)->create();
    }
}
