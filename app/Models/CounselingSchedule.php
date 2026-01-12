<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CounselingSchedule extends Model
{
    protected $fillable = [
        'counseling_request_id', 'topic_id', 'scheduled_date', 'start_time', 'end_time', 
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

    public function topic()
    {
        return $this->belongsTo(Topic::class, 'topic_id');
    }

    public function counselingRequest()
    {
        return $this->belongsTo(CounselingRequest::class);
    }

    // Relasi ke CounselingSession
    public function session()
    {
        return $this->hasOne(CounselingSession::class, 'schedule_id');
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Singkronkan status jadwal ke permintaan (CounselingRequest) jika ada
        static::updated(function ($schedule) {
            if ($schedule->counselingRequest) {
                // Mapping status jadwal ke status permintaan (CR menggunakan 'canceled' dengan satu L)
                $statusMapping = [
                    'completed' => 'completed',
                    'cancelled' => 'canceled',
                    'scheduled' => 'approved',
                ];

                if (isset($statusMapping[$schedule->status])) {
                    $schedule->counselingRequest->update([
                        'status' => $statusMapping[$schedule->status]
                    ]);
                }
            }
        });
    }
}