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
        Schema::create('public_reports', function (Blueprint $table) {
            $table->id();
            $table->string('report_code')->unique();
            $table->foreignId('user_id')->constrained('users');
            $table->string('location');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->decimal('water_level', 8, 2);
            $table->string('photo')->nullable();
            $table->text('note')->nullable();
            $table->text('admin_note')->nullable();

            // Alur Validasi Admin
            $table->enum('status', ['pending', 'diproses', 'selesai', 'emergency'])->default('pending');
            $table->foreignId('validated_by')->nullable()->constrained('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public_reports');
    }
};
