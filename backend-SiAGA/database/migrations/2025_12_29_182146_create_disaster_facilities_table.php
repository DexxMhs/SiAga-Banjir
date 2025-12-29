<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('disaster_facilities', function (Blueprint $table) {
            $table->id();
            $table->string('unique_code', 20);
            $table->string('name'); // Nama Tempat (misal: Masjid Al-Makmur)
            $table->enum('type', ['pengungsian', 'dapur_umum', 'posko_kesehatan', 'logistik']); // Jenis Fasilitas
            $table->enum('status', ['buka', 'tutup', 'penuh'])->default('buka'); // Status operasional
            $table->text('address'); // Alamat Lengkap

            // Koordinat (Penting untuk Google Maps)
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);

            $table->string('photo_path')->nullable(); // Foto lokasi
            $table->text('notes')->nullable(); // Catatan (misal: "Bawa selimut sendiri", "Kapasitas 50 orang")

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disaster_facilities');
    }
};
