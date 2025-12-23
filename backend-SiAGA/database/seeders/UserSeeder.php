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
            'username' => 'admin',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        // Petugas Lapangan [cite: 20]
        \App\Models\User::create([
            'name' => 'Petugas Lapangan 01',
            'username' => 'petugas',
            'password' => bcrypt('password123'),
            'role' => 'petugas',
        ]);

        // Masyarakat Umum [cite: 27]
        $region = \App\Models\Region::first();
        \App\Models\User::create([
            'name' => 'Warga Budiman',
            'username' => 'warga',
            'password' => bcrypt('password123'),
            'role' => 'public',
            'region_id' => $region->id,
        ]);
    }
}
