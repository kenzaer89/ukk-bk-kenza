<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CounselingRequest extends Model
{
    use HasFactory;
    
    protected $table = 'counseling_requests';

    protected $fillable = [
        'student_id',
        'teacher_id', // Bisa null saat diajukan
        'topic_id',   // ID topik konseling
        'reason',     // Deskripsi/Topik dari form siswa
        'status',     // default 'pending'
        'requested_at',
        'notes',      // Catatan admin (untuk penolakan/penundaan)
    ];

    protected $casts = [
        'requested_at' => 'datetime',
    ];
    
    // Relasi ke Siswa
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // Relasi ke Guru BK
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    // Relasi ke Topic
    public function topic()
    {
        return $this->belongsTo(Topic::class, 'topic_id');
    }

    // Relasi ke Jadwal (jika sudah disetujui dan dijadwalkan)
    public function schedule()
    {
        return $this->hasOne(CounselingSchedule::class, 'counseling_request_id');
    }
}