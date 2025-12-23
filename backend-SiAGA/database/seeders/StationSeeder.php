<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Station::create([
            'name' => 'Pintu Air Manggarai',
            'location' => 'Jakarta Selatan',
            'latitude' => -6.208174,
            'longitude' => 106.844172,
            'water_level' => 140.00,
            'status' => 'normal', // [cite: 53, 127]
            'last_update' => now(),
        ]);

        \App\Models\Station::create([
            'name' => 'Pintu Air Katulampa',
            'location' => 'Bogor',
            'latitude' => -6.6331,
            'longitude' => 106.8372,
            'water_level' => 180.00,
            'status' => 'siaga', // [cite: 128]
            'last_update' => now(),
        ]);
    }
}
