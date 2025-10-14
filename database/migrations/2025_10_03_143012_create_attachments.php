<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('counseling_sessions')->cascadeOnDelete();
            $table->string('filename', 255);
            $table->string('path', 1024);
            $table->string('mime_type', 100)->nullable();
            $table->bigInteger('size_bytes')->nullable();

            // ✅ Perbaikan utama: tambahkan timestamps
            $table->timestamps();

            $table->index('session_id', 'idx_attachments_session_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
