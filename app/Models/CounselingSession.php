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
        'session_type', // individual, group, referral
        'request_reason', // Alasan permintaan (saat siswa buat)
        'session_date',
        'start_time',
        'end_time',
        'location',
        'notes', // Catatan hasil sesi (diisi Guru BK)
        'status', // requested, scheduled, completed, cancelled
        'follow_up_required',
    ];
    
    protected $casts = [
        'session_date' => 'date',
        'follow_up_required' => 'boolean',
    ];
    
    // Relasi ke Siswa (Requester)
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id')->with('studentClass');
    }
    
    // Relasi ke Konselor (Guru BK)
    public function counselor()
    {
        return $this->belongsTo(User::class, 'counselor_id');
    }

    // Relasi ke Topik (Many-to-Many)
    public function topics()
    {
        return $this->belongsToMany(Topic::class, 'session_topic', 'session_id', 'topic_id');
    }
}