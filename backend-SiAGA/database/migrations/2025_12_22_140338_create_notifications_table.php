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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // Null jika broadcast ke semua
            $table->string('title');
            $table->text('message');
            $table->string('type'); // 'flood_alert', 'broadcast_manual'
            $table->json('data')->nullable(); // Untuk menyimpan metadata tambahan (misal station_id)
            $table->timestamp('read_at')->nullable(); // Untuk fitur "tandai sudah dibaca"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
