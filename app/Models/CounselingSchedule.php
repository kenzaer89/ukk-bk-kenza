<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CounselingSchedule extends Model
{
    use HasFactory;

    protected $table = 'counseling_schedules';

    protected $fillable = [
        'student_id',
        'teacher_id',
        'scheduled_date',
        'start_time',
        'end_time',
        'status',      // scheduled, completed, cancelled
        'admin_notes',
    ];

    protected $dates = [
        'scheduled_date',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function session()
    {
        return $this->hasOne(CounselingSession::class, 'schedule_id');
    }
}
