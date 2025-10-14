<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = ['name', 'jurusan', 'wali_kelas_id'];

    // Relasi ke User (Wali Kelas)
    public function waliKelas()
    {
        return $this->belongsTo(User::class, 'wali_kelas_id');
    }

    // Relasi ke siswa
    public function students()
    {
        return $this->hasMany(User::class, 'class_id');
    }
}
