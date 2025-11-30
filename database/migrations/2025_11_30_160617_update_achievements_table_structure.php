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
        Schema::table('achievements', function (Blueprint $table) {
            // Tambah teacher_id jika belum ada
            if (!Schema::hasColumn('achievements', 'teacher_id')) {
                $table->foreignId('teacher_id')->nullable()->after('student_id')->constrained('users')->nullOnDelete();
            }
            
            // Tambah point jika belum ada
            if (!Schema::hasColumn('achievements', 'point')) {
                $table->integer('point')->default(0)->after('level');
            }
            
            // Tambah description jika belum ada
            if (!Schema::hasColumn('achievements', 'description')) {
                $table->text('description')->nullable()->after('achievement_date');
            }
            
            // Ubah level menjadi string agar lebih fleksibel
            $table->string('level', 100)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('achievements', function (Blueprint $table) {
            $table->dropForeign(['teacher_id']);
            $table->dropColumn(['teacher_id', 'point', 'description']);
            // Level tidak bisa dikembalikan ke enum dengan mudah, biarkan string
        });
    }
};
