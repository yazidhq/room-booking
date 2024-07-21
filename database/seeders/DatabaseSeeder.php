<?php

namespace Database\Seeders;

use App\Models\Ruang;
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

        Ruang::insert([
            'nama_ruang' => 'Ruang A',
            'jam_buka' => '07',
            'jam_tutup' => '17',
        ]);

        Ruang::insert([
            'nama_ruang' => 'Ruang B',
            'jam_buka' => '08',
            'jam_tutup' => '16',
        ]);

        Ruang::insert([
            'nama_ruang' => 'Ruang C',
            'jam_buka' => '06',
            'jam_tutup' => '14',
        ]);
    }
}
