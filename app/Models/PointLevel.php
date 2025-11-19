<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointLevel extends Model
{
    use HasFactory;
    
    protected $table = 'point_levels'; 

    protected $fillable = [
        'point_threshold', // Ambang batas poin (misal: 50, 75, 100)
        'action',          // Tindakan yang harus dilakukan (misal: Panggil Ortu, Skorsing)
    ];
    
    // Opsional: Atribut yang akan di-cast ke integer
    protected $casts = [
        'point_threshold' => 'integer',
    ];
}