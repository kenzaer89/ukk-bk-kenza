<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Violation extends Model
{
    use HasFactory;
    
    protected $table = 'violations'; 

    protected $fillable = [
        'student_id',
        'rule_id',
        'teacher_id',
        'violation_date',
        'description',
        'follow_up_action',
        'status', // pending, resolved, escalated
    ];
    
    protected $casts = [
        'violation_date' => 'date',
    ];
    
    // Relasi ke Siswa
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id')->with('studentClass');
    }
    
    // Relasi ke Aturan Pelanggaran
    public function rule()
    {
        return $this->belongsTo(Rule::class, 'rule_id');
    }
    
    // Relasi ke Guru Pencatat
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}