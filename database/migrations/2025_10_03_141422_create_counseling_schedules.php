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
       Schema::create('counseling_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('counseling_request_id')->nullable()->constrained('counseling_requests')->nullOnDelete();
            $table->foreignId('topic_id')->nullable()->constrained('topics')->nullOnDelete();
            $table->date('scheduled_date');
            $table->time('start_time');
            $table->time('end_time')->nullable();
            $table->string('location', 255)->nullable();
            $table->enum('status',['scheduled','completed','cancelled'])->default('scheduled');
            $table->boolean('is_visible_to_admin')->default(true);
            $table->text('student_notes')->nullable();
            $table->text('admin_notes')->nullable();
            $table->enum('attendance_student',['present','absent'])->nullable();
            $table->enum('attendance_teacher',['present','absent'])->nullable();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('teacher_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->string('teacher_name')->nullable();
            $table->timestamps();


            $table->index('scheduled_date','idx_sched_scheduled_date');
            $table->index('student_id','idx_sched_student_id');
            $table->index('teacher_id','idx_sched_teacher_id');
            $table->index('status','idx_sched_status');
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counseling_schedules');
    }
};
