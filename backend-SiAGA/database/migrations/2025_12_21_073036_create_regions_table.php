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
            $table->id(); // [cite: 56]
            $table->string('name'); // [cite: 57]
            $table->enum('flood_status', ['normal', 'siaga', 'awas'])->default('normal'); //
            $table->foreignId('influenced_by_station_id')->constrained('stations')->onDelete('cascade'); //
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
