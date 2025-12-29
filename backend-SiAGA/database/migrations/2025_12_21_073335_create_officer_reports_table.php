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
        Schema::create('officer_reports', function (Blueprint $table) {
            $table->id(); // [cite: 61]
            $table->string('report_code')->unique();
            $table->foreignId('officer_id')->constrained('users'); // [cite: 62]
            $table->foreignId('station_id')->constrained('stations'); // [cite: 63]
            $table->decimal('water_level', 8, 2); // [cite: 64]
            $table->string('rainfall')->nullable(); // [cite: 65]
            $table->string('pump_status')->nullable(); // [cite: 66]
            $table->enum('calculated_status', ['normal', 'siaga', 'awas'])->nullable(); // [cite: 67]
            $table->string('photo')->nullable(); // [cite: 68]
            $table->text('note')->nullable(); // [cite: 69]
            $table->text('admin_note')->nullable(); // [cite: 69]

            // Alur Validasi Admin [cite: 98, 99]
            $table->enum('validation_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('validated_by')->nullable()->constrained('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('officer_reports');
    }
};
