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
       Schema::create('classes', function (Blueprint $table) {
        $table->id();
        $table->string('name',100);
        $table->string('jurusan',100)->nullable();
        $table->unsignedBigInteger('wali_kelas_id')->nullable(); // FK ditambahkan di migration tambahan
        $table->timestamps();


        $table->index('wali_kelas_id','idx_classes_wali_kelas_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
