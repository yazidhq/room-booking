<?php

namespace Database\Seeders;

use App\Models\User;
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
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'status' => 'admin',
            'password' => Hash::make("password")
        ]);

        User::factory()->create([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'status' => 'mahasiswa',
            'password' => Hash::make("password")
        ]);
    }
}
