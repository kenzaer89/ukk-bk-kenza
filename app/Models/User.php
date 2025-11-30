<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // if you use auth features
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',       // admin, guru_bk, student, parent, wali_kelas
        'phone',
        'class_id',   // optional
        'absen',      // nomor absen
        'specialization', // jurusan
        'points',     // poin pelanggaran (default 100)
        'extra',      // any extra json/text column
    ];

    protected $hidden = [
        'password',
    ];

    // Relations

    // counseling requests where this user is requester (some DB use id_user)
    public function counselingRequests()
    {
        return $this->hasMany(CounselingRequest::class, 'id_user');
    }

    // schedules where user is student
    public function schedulesAsStudent()
    {
        return $this->hasMany(CounselingSchedule::class, 'student_id');
    }

    // schedules where user is teacher/guru
    public function schedulesAsTeacher()
    {
        return $this->hasMany(CounselingSchedule::class, 'teacher_id');
    }

    // sessions through schedules (convenience)
    public function sessions()
    {
        return $this->hasManyThrough(
            CounselingSession::class,
            CounselingSchedule::class,
            'student_id', // Foreign key on schedules table...
            'schedule_id', // Foreign key on sessions table...
            'id', // Local key on users table...
            'id'  // Local key on schedules table...
        );
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id');
    }

    public function violations()
    {
        return $this->hasMany(Violation::class, 'student_id');
    }

    public function scopeStudents($query)
    {
        return $query->where('role', 'student');
    }

    public function scopeWaliKelas($query)
    {
        return $query->where('role', 'wali_kelas');
    }
    
    public function parentConnections()
    {
        return $this->hasMany(ParentStudent::class, 'parent_id');
    }

    public function childrenConnections()
    {
        return $this->hasMany(ParentStudent::class, 'student_id');
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }
}
