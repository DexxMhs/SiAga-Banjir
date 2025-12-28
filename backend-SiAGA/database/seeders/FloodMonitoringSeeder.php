<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Station;
use App\Models\Region;
use Illuminate\Support\Facades\DB;

class FloodMonitoringSeeder extends Seeder
{
    public function run()
    {
        // 1. Bersihkan tabel lama (Truncate)
        // Kita matikan dulu pengecekan foreign key agar tidak error saat menghapus
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // DB::table('region_station')->truncate();
        // Station::truncate();
        // Region::truncate();
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ==========================================
        // 2. Insert Data Stasiun (10 Data)
        // ==========================================
        $stations = [
            [
                'name' => 'Bendung Katulampa',
                'location' => 'Bogor, Jawa Barat',
                'latitude' => -6.6331,
                'longitude' => 106.8372,
                'water_level' => 120,
                'status' => 'siaga',
                'threshold_siaga' => 150,
                'threshold_awas' => 250
            ],
            [
                'name' => 'Pos Pantau Depok',
                'location' => 'Depok, Jawa Barat',
                'latitude' => -6.4036,
                'longitude' => 106.8306,
                'water_level' => 150,
                'status' => 'normal',
                'threshold_siaga' => 200,
                'threshold_awas' => 300
            ],
            [
                'name' => 'Pintu Air Manggarai',
                'location' => 'Jakarta Selatan',
                'latitude' => -6.2082,
                'longitude' => 106.8442,
                'water_level' => 850,
                'status' => 'awas',
                'threshold_siaga' => 750,
                'threshold_awas' => 850
            ],
            [
                'name' => 'Pintu Air Karet',
                'location' => 'Tanah Abang, Jakarta Pusat',
                'latitude' => -6.1989,
                'longitude' => 106.8169,
                'water_level' => 520,
                'status' => 'siaga',
                'threshold_siaga' => 450,
                'threshold_awas' => 600
            ],
            [
                'name' => 'Pos Angke Hulu',
                'location' => 'Tangerang',
                'latitude' => -6.2297,
                'longitude' => 106.6894,
                'water_level' => 100,
                'status' => 'normal',
                'threshold_siaga' => 150,
                'threshold_awas' => 250
            ],
            [
                'name' => 'Pos Pesanggrahan',
                'location' => 'Jakarta Selatan',
                'latitude' => -6.2778,
                'longitude' => 106.7658,
                'water_level' => 90,
                'status' => 'normal',
                'threshold_siaga' => 150,
                'threshold_awas' => 250
            ],
            [
                'name' => 'Pos Sunter Hulu',
                'location' => 'Jakarta Timur',
                'latitude' => -6.3094,
                'longitude' => 106.8967,
                'water_level' => 180,
                'status' => 'siaga',
                'threshold_siaga' => 150,
                'threshold_awas' => 200
            ],
            [
                'name' => 'Pintu Air Pulo Gadung',
                'location' => 'Jakarta Timur',
                'latitude' => -6.1878,
                'longitude' => 106.9022,
                'water_level' => 450,
                'status' => 'normal',
                'threshold_siaga' => 550,
                'threshold_awas' => 700
            ],
            [
                'name' => 'Pasar Ikan (Laut)',
                'location' => 'Penjaringan, Jakarta Utara',
                'latitude' => -6.1261,
                'longitude' => 106.8097,
                'water_level' => 240,
                'status' => 'awas',
                'threshold_siaga' => 170,
                'threshold_awas' => 220
            ],
            [
                'name' => 'Pos Krukut Hulu',
                'location' => 'Ciganjur, Depok',
                'latitude' => -6.3533,
                'longitude' => 106.8011,
                'water_level' => 110,
                'status' => 'normal',
                'threshold_siaga' => 150,
                'threshold_awas' => 250
            ],
        ];

        foreach ($stations as $data) {
            Station::create([
                'name' => $data['name'],
                'location' => $data['location'],
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
                'water_level' => $data['water_level'],
                'status' => $data['status'],
                'threshold_siaga' => $data['threshold_siaga'],
                'threshold_awas' => $data['threshold_awas'],
                'last_update' => now(),
            ]);
        }

        // ==========================================
        // 3. Insert Data Wilayah (10 Data)
        // ==========================================
        $regions = [
            [
                'name' => 'Kel. Bidara Cina',
                'location' => 'Jatinegara, Jakarta Timur',
                'latitude' => -6.2330,
                'longitude' => 106.8610,
                'flood_status' => 'awas',
                'risk_note' => 'Banjir kiriman dari Bogor (Katulampa) biasanya sampai dalam 9-12 jam.'
            ],
            [
                'name' => 'Kel. Kampung Melayu',
                'location' => 'Jatinegara, Jakarta Timur',
                'latitude' => -6.2270,
                'longitude' => 106.8580,
                'flood_status' => 'awas',
                'risk_note' => 'Area bantaran kali Ciliwung, sangat rawan luapan.'
            ],
            [
                'name' => 'Kel. Bukit Duri',
                'location' => 'Tebet, Jakarta Selatan',
                'latitude' => -6.2230,
                'longitude' => 106.8560,
                'flood_status' => 'siaga',
                'risk_note' => 'Genangan sering terjadi di RW 10, 11, dan 12.'
            ],
            [
                'name' => 'Kel. Rawajati',
                'location' => 'Pancoran, Jakarta Selatan',
                'latitude' => -6.2580,
                'longitude' => 106.8520,
                'flood_status' => 'normal',
                'risk_note' => 'Waspada jika Pos Depok mencapai Siaga 2.'
            ],
            [
                'name' => 'Kel. Cawang',
                'location' => 'Kramat Jati, Jakarta Timur',
                'latitude' => -6.2510,
                'longitude' => 106.8630,
                'flood_status' => 'normal',
                'risk_note' => 'Aman terkendali, drainase lancar.'
            ],
            [
                'name' => 'Kawasan Pluit',
                'location' => 'Penjaringan, Jakarta Utara',
                'latitude' => -6.1150,
                'longitude' => 106.7900,
                'flood_status' => 'awas',
                'risk_note' => 'Rawan Banjir Rob akibat air laut pasang.'
            ],
            [
                'name' => 'Kel. Kemang',
                'location' => 'Mampang Prapatan, Jaksel',
                'latitude' => -6.2650,
                'longitude' => 106.8150,
                'flood_status' => 'normal',
                'risk_note' => 'Rawan luapan Kali Krukut saat hujan lokal deras.'
            ],
            [
                'name' => 'Kel. Kelapa Gading',
                'location' => 'Jakarta Utara',
                'latitude' => -6.1600,
                'longitude' => 106.9000,
                'flood_status' => 'siaga',
                'risk_note' => 'Sistem drainase lambat, waspada hujan durasi lama.'
            ],
            [
                'name' => 'Green Garden',
                'location' => 'Kedoya Utara, Jakarta Barat',
                'latitude' => -6.1650,
                'longitude' => 106.7600,
                'flood_status' => 'normal',
                'risk_note' => 'Dipengaruhi debit air Kali Angke.'
            ],
            [
                'name' => 'Kawasan Ancol',
                'location' => 'Pademangan, Jakarta Utara',
                'latitude' => -6.1200,
                'longitude' => 106.8300,
                'flood_status' => 'siaga',
                'risk_note' => 'Waspada gelombang tinggi dan pasang air laut.'
            ],
        ];

        foreach ($regions as $data) {
            Region::create([
                'name' => $data['name'],
                'location' => $data['location'],
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
                'flood_status' => $data['flood_status'],
                'risk_note' => $data['risk_note'],
                // Photo dikosongkan atau bisa diisi path dummy
                'photo' => null,
            ]);
        }

        // ==========================================
        // 4. Hubungkan Relasi (Pivot Table)
        // ==========================================

        // Ambil ID Stasiun untuk referensi
        $katulampa = Station::where('name', 'Bendung Katulampa')->first();
        $depok = Station::where('name', 'Pos Pantau Depok')->first();
        $manggarai = Station::where('name', 'Pintu Air Manggarai')->first();
        $pasarIkan = Station::where('name', 'Pasar Ikan (Laut)')->first();
        $krukut = Station::where('name', 'Pos Krukut Hulu')->first();
        $angke = Station::where('name', 'Pos Angke Hulu')->first();
        $sunter = Station::where('name', 'Pos Sunter Hulu')->first();

        // 1. Bidara Cina (Ciliwung) -> Dipengaruhi Katulampa, Depok, Manggarai
        $bidara = Region::where('name', 'Kel. Bidara Cina')->first();
        $bidara->relatedStations()->attach([
            $katulampa->id => ['impact_percentage' => 40, 'travel_time_minutes' => 600], // 10 jam dari Bogor
            $depok->id => ['impact_percentage' => 70, 'travel_time_minutes' => 360],     // 6 jam dari Depok
            $manggarai->id => ['impact_percentage' => 90, 'travel_time_minutes' => 15],  // Dekat
        ]);

        // 2. Kampung Melayu (Ciliwung)
        $melayu = Region::where('name', 'Kel. Kampung Melayu')->first();
        $melayu->relatedStations()->attach([
            $katulampa->id => ['impact_percentage' => 40, 'travel_time_minutes' => 600],
            $depok->id => ['impact_percentage' => 70, 'travel_time_minutes' => 360],
            $manggarai->id => ['impact_percentage' => 95, 'travel_time_minutes' => 10],
        ]);

        // 3. Pluit (Rob) -> Dipengaruhi Pasar Ikan
        $pluit = Region::where('name', 'Kawasan Pluit')->first();
        $pluit->relatedStations()->attach([
            $pasarIkan->id => ['impact_percentage' => 100, 'travel_time_minutes' => 0],
        ]);

        // 4. Kemang (Krukut)
        $kemang = Region::where('name', 'Kel. Kemang')->first();
        $kemang->relatedStations()->attach([
            $krukut->id => ['impact_percentage' => 85, 'travel_time_minutes' => 120], // 2 jam dari hulu
        ]);

        // 5. Green Garden (Angke)
        $garden = Region::where('name', 'Green Garden')->first();
        $garden->relatedStations()->attach([
            $angke->id => ['impact_percentage' => 80, 'travel_time_minutes' => 240], // 4 jam dari hulu
        ]);

        // 6. Kelapa Gading (Sunter)
        $gading = Region::where('name', 'Kel. Kelapa Gading')->first();
        $gading->relatedStations()->attach([
            $sunter->id => ['impact_percentage' => 75, 'travel_time_minutes' => 180], // 3 jam
        ]);

        // 7. Ancol (Rob)
        $ancol = Region::where('name', 'Kawasan Ancol')->first();
        $ancol->relatedStations()->attach([
            $pasarIkan->id => ['impact_percentage' => 90, 'travel_time_minutes' => 10],
        ]);
    }
}
