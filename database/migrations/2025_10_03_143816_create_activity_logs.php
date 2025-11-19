<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // Siapa yang melakukan
            $table->string('log_type'); // Contoh: 'Violation', 'User', 'Counseling'
            $table->string('action'); // Contoh: 'created', 'updated', 'deleted', 'scheduled'
            $table->morphs('loggable'); // Relasi polimorfik ke objek yang diubah (e.g., Violation, User)
            $table->text('old_data')->nullable(); // Data sebelum perubahan (untuk update)
            $table->text('new_data')->nullable(); // Data setelah perubahan
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
            
            // Indeks untuk pencarian cepat
            $table->index(['log_type', 'action']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};