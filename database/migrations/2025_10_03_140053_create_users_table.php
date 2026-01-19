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
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name',191);
                $table->string('email',191)->unique();
                $table->string('password',191);
                $table->enum('role',['student','parent','wali_kelas','guru_bk','admin'])->default('student');
                $table->string('nis',50)->nullable();
                $table->string('nip',50)->nullable();
                $table->string('phone',30)->nullable();
                $table->text('address')->nullable();
                $table->string('relationship_to_student',100)->nullable();
                $table->unsignedBigInteger('class_id')->nullable(); // FK ditambahkan di migration tambahan
                $table->string('specialization',191)->nullable();

                // Kolom tambahan untuk Laravel Auth kompatibel seeder
                $table->timestamp('email_verified_at')->nullable();
                $table->string('remember_token',100)->nullable();


                $table->timestamps();
                $table->softDeletes();


                $table->index('nis','idx_users_nis');
                $table->index('role','idx_users_role');
                $table->index('class_id','idx_users_class_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
