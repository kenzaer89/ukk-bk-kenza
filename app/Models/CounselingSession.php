<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CounselingSession extends Model
{
    use HasFactory;

    protected $table = 'counseling_sessions';

    protected $fillable = [
        'schedule_id',
        'session_date',
        'teacher_notes',
        'recommendations',
    ];

    protected $dates = ['session_date'];

    public function schedule()
    {
        return $this->belongsTo(CounselingSchedule::class, 'schedule_id');
    }

    public function files()
    {
        return $this->hasMany(CounselingFile::class, 'session_id');
    }

    public function teacher()
    {
        // convenience: get teacher through schedule
        return $this->hasOneThrough(User::class, CounselingSchedule::class, 'id', 'id', 'schedule_id', 'teacher_id');
    }

    public function topics()
    {
        return $this->belongsToMany(Topic::class, 'session_topic', 'session_id', 'topic_id');
    }

}
