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
        Schema::create('counseling_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->constrained('counseling_schedules')->cascadeOnDelete();
            $table->date('session_date');
            $table->text('teacher_notes')->nullable();
            $table->text('recommendations')->nullable();
            $table->timestamps();


            $table->index('schedule_id','idx_sessions_schedule_id');
            $table->index('session_date','idx_sessions_session_date');
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counseling_sessions');
    }
};
