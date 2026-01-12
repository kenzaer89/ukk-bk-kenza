<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CounselingSession extends Model
{
    use HasFactory;
    
    protected $table = 'counseling_sessions'; 

    protected $fillable = [
        'student_id',
        'counselor_id',
        'schedule_id',
        'session_type',
        'session_date',
        'start_time',
        'end_time',
        'location',
        'notes',
        'status',
        'follow_up_required',
        'teacher_notes',
        'recommendations',
    ];
    
    protected $casts = [
        'session_date' => 'date',
    ];
    
    // Relasi ke Schedule
    public function schedule()
    {
        return $this->belongsTo(CounselingSchedule::class, 'schedule_id');
    }
    
    
    // Relasi ke Siswa
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
    
    // Relasi ke Konselor
    public function counselor()
    {
        return $this->belongsTo(User::class, 'counselor_id');
    }

    // Relasi ke Topics (many-to-many)
    public function topics()
    {
        return $this->belongsToMany(Topic::class, 'session_topic', 'session_id', 'topic_id');
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Ketika sesi diupdate, sinkronisasi status dengan jadwal
        static::updated(function ($session) {
            if ($session->schedule_id && in_array($session->status, ['completed', 'cancelled'])) {
                $session->schedule()->update(['status' => $session->status]);
            }
        });
    }
}