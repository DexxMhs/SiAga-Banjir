<?php

namespace Database\Seeders;

use App\Models\NotificationSettingRule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotificationSettingRuleSeeder extends Seeder
{
    /**
     * Jalankan database seeds.
     */
    public function run(): void
    {
        $rules = [
            [
                'status_type' => 'siaga',
                'message_template' => 'Waspada! Ketinggian air di [station] telah memasuki level [status]. Warga di wilayah terdampak harap bersiap.',
            ],
            [
                'status_type' => 'awas',
                'message_template' => 'Peringatan Darurat! [station] saat ini berstatus [status]. Segera evakuasi ke tempat yang lebih aman!',
            ],
        ];

        foreach ($rules as $rule) {
            NotificationSettingRule::updateOrCreate(
                ['status_type' => $rule['status_type']], // Cek berdasarkan status_type agar tidak duplikat
                ['message_template' => $rule['message_template']]
            );
        }
    }
}
