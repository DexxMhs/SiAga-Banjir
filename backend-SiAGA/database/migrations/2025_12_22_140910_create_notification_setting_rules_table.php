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
        Schema::create('notification_setting_rules', function (Blueprint $table) {
            $table->id();
            $table->string('status_type'); // siaga atau awas
            $table->text('message_template'); // Contoh: "Status di [station] menjadi [status]. Harap waspada!"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_setting_rules');
    }
};
