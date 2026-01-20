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
            $table->foreignId('student_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('counselor_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->string('counselor_name')->nullable();
            $table->foreignId('schedule_id')->nullable()->constrained('counseling_schedules')->cascadeOnDelete();
            $table->string('session_type')->default('individual');
            $table->date('session_date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('location')->nullable();
            $table->string('status')->default('completed');
            $table->boolean('follow_up_required')->default(false);
            $table->text('teacher_notes')->nullable();
            $table->text('notes')->nullable();
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
