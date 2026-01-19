<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'teacher_id',
        'name', 
        'level',
        'achievement_date',
        'description',
        'notes',
        'point',
        'is_visible_to_admin',
    ];

    protected $casts = [
        'achievement_date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}