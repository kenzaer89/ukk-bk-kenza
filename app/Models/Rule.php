<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    use HasFactory;
    
    protected $table = 'rules'; 

    protected $fillable = [
        'name',
        'points', // Poin yang dikurangi (nilai positif)
        'description',
        'category',
    ];
    
    // Relasi ke Pelanggaran
    public function violations()
    {
        return $this->hasMany(Violation::class, 'rule_id');
    }
}