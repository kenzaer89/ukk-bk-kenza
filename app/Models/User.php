<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // if you use auth features
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected static function booted()
    {
        static::creating(function ($user) {
            if ($user->role === 'student') {
                $user->points = $user->points ?? 100;
            } else {
                $user->points = null;
            }
        });
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',       // admin, guru_bk, student, parent, wali_kelas
        'phone',
        'nisn',       // nomor induk siswa nasional
        'nip',        // nomor induk pegawai
        'class_id',   // optional
        'absen',      // nomor absen
        'specialization', // jurusan
        'points',     // poin pelanggaran (default 100)
        'is_approved', // status persetujuan
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

    // sessions for this student
    public function sessions()
    {
        return $this->hasMany(CounselingSession::class, 'student_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id');
    }

    public function violations()
    {
        return $this->hasMany(Violation::class, 'student_id');
    }

    public function achievements()
    {
        return $this->hasMany(Achievement::class, 'student_id');
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

    /**
     * Many-to-many relationship: parent users to their students
     * Used for parent role to manage their children/students
     */
    public function students()
    {
        return $this->belongsToMany(
            User::class,
            'parent_student',
            'parent_id',
            'student_id'
        );
    }

    public function managedClass()
    {
        return $this->hasOne(SchoolClass::class, 'wali_kelas_id');
    }

    public function getSpecializationFullNameAttribute()
    {
        if ($this->schoolClass) {
            return $this->schoolClass->jurusan_full_name;
        }

        $map = [
            'RPL' => 'Rekayasa Perangkat Lunak',
            'TITL' => 'Teknik Instalasi Tenaga Listrik',
            'TKR' => 'Teknik Kendaraan Ringan',
            'TPM' => 'Teknik Permesinan'
        ];
        $abbr = strtoupper($this->specialization ?? '');
        return $map[$abbr] ?? ($this->specialization ?? '-');
    }

    public function getRoleDisplayNameAttribute()
    {
        $map = [
            'admin' => 'Admin BK',
            'guru_bk' => 'Guru BK',
            'wali_kelas' => 'Wali Kelas',
            'student' => 'Murid',
            'parent' => 'Orang Tua'
        ];

        return $map[$this->role] ?? ucfirst(str_replace('_', ' ', $this->role));
    }
}
