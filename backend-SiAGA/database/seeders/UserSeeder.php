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
            'phone' => '081122223333',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        // Petugas Lapangan [cite: 20]
        \App\Models\User::create([
            'name' => 'Petugas Lapangan 01',
            'email' => 'petugas1@example.com',
            'username' => 'petugas',
            'phone' => '081122223334',
            'password' => bcrypt('password123'),
            'nomor_induk' => 'PTG-20251228-001',
            'role' => 'petugas',
        ]);

        \App\Models\User::create([
            'name' => 'Petugas Lapangan 02',
            'email' => 'petugas2@example.com',
            'username' => 'petugas2',
            'phone' => '081122223335',
            'password' => bcrypt('password123'),
            'role' => 'petugas',
        ]);

        // Masyarakat Umum [cite: 27]
        $region = \App\Models\Region::first();
        \App\Models\User::create([
            'name' => 'Warga Budiman',
            'email' => 'warga1@example.com',
            'username' => 'warga',
            'phone' => '081122223336',
            'password' => bcrypt('password123'),
            'role' => 'public',
            'region_id' => $region->id,
        ]);

        \App\Models\User::create([
            'name' => 'Warga Sejahtera',
            'email' => 'warga2@example.com',
            'username' => 'warga2',
            'phone' => '081122223337',
            'password' => bcrypt('password123'),
            'role' => 'public',
            'region_id' => $region->id,
        ]);
    }
}
