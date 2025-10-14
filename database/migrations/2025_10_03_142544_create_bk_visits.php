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
        Schema::create('bk_visits', function (Blueprint $table) {
            $table->id();
            $table->date('visit_date');
            $table->text('reason')->nullable();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained('users')->cascadeOnDelete();

            // ✅ Tambahkan timestamps lengkap
            $table->timestamps();

            $table->index('visit_date', 'idx_bk_visits_visit_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bk_visits'); 
    }
};
