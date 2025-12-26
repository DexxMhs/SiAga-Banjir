<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin Pusat [cite: 9, 14]
        \App\Models\User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@example.com',
            'username' => 'admin',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        // Petugas Lapangan [cite: 20]
        \App\Models\User::create([
            'name' => 'Petugas Lapangan 01',
            'email' => 'petugas1@example.com',
            'username' => 'petugas',
            'password' => bcrypt('password123'),
            'role' => 'petugas',
        ]);

        \App\Models\User::create([
            'name' => 'Petugas Lapangan 02',
            'email' => 'petugas2@example.com',
            'username' => 'petugas2',
            'password' => bcrypt('password123'),
            'role' => 'petugas',
        ]);

        // Masyarakat Umum [cite: 27]
        $region = \App\Models\Region::first();
        \App\Models\User::create([
            'name' => 'Warga Budiman',
            'email' => 'warga1@example.com',
            'username' => 'warga',
            'password' => bcrypt('password123'),
            'role' => 'public',
            'region_id' => $region->id,
        ]);

        \App\Models\User::create([
            'name' => 'Warga Sejahtera',
            'email' => 'warga2@example.com',
            'username' => 'warga2',
            'password' => bcrypt('password123'),
            'role' => 'public',
            'region_id' => $region->id,
        ]);
    }
}
