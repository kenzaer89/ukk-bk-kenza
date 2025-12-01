<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CounselingSchedule extends Model
{
    protected $fillable = [
        'counseling_request_id', 'scheduled_date', 'start_time', 'end_time', 
        'location', 'status', 'student_notes', 'admin_notes', 'student_id', 'teacher_id'
    ];

    protected $casts = [
        'scheduled_date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function counselingRequest()
    {
        return $this->belongsTo(CounselingRequest::class);
    }
}