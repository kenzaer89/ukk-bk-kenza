<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'name',
        'jurusan',
        'wali_kelas_id', // teacher in charge
        'extra',
    ];

    public function students()
    {
        return $this->hasMany(User::class, 'class_id');
    }

    public function waliKelas()
    {
        return $this->belongsTo(User::class, 'wali_kelas_id');
    }

    public function getJurusanFullNameAttribute()
    {
        $map = [
            'RPL' => 'Rekayasa Perangkat Lunak',
            'TITL' => 'Teknik Instalasi Tenaga Listrik',
            'TKR' => 'Teknik Kendaraan Ringan',
            'TPM' => 'Teknik Permesinan'
        ];
        $abbr = strtoupper($this->jurusan ?? '');
        return $map[$abbr] ?? ($this->jurusan ?? '-');
    }
}
