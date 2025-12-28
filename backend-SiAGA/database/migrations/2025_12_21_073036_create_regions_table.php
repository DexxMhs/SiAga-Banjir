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
        Schema::create('regions', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            // Kolom Baru Tambahan
            $table->string('photo')->nullable(); // Foto wilayah
            $table->string('location')->nullable(); // Nama jalan/lokasi rinci
            $table->decimal('latitude', 10, 8)->nullable(); // Koordinat Lat
            $table->decimal('longitude', 11, 8)->nullable(); // Koordinat Long

            $table->enum('flood_status', ['normal', 'siaga', 'awas'])->default('normal');

            // Catatan risiko
            $table->text('risk_note')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regions');
    }
};
