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
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('teacher_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('name', 255);
            $table->string('level', 100)->default('school');
            $table->integer('point')->default(0);
            $table->boolean('is_visible_to_admin')->default(true);
            $table->date('achievement_date')->nullable();
            $table->text('notes')->nullable();
            $table->text('description')->nullable();
            $table->timestamps(); // created_at & updated_at otomatis

            $table->index('student_id', 'idx_achievements_student_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achievements');
    }
};
