<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stasiunManggarai = \App\Models\Station::where('name', 'Pintu Air Manggarai')->first();

        \App\Models\Region::create([
            'name' => 'Kampung Melayu',
            'flood_status' => 'normal',
            'influenced_by_station_id' => $stasiunManggarai->id, // [cite: 59]
        ]);

        \App\Models\Region::create([
            'name' => 'Tebet',
            'flood_status' => 'normal',
            'influenced_by_station_id' => $stasiunManggarai->id,
        ]);
    }
}
