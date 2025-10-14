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
       Schema::create('counseling_requests', function (Blueprint $table) {
        $table->id();
        $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
        $table->foreignId('teacher_id')->nullable()->constrained('users')->nullOnDelete();
        $table->timestamp('requested_at')->useCurrent();
        $table->text('reason')->nullable();
        $table->enum('status',['pending','approved','rejected'])->default('pending');
        $table->timestamps();


        $table->index('student_id','idx_cr_student_id');
        $table->index('teacher_id','idx_cr_teacher_id');
        $table->index('status','idx_cr_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counseling_requests');
    }
};
