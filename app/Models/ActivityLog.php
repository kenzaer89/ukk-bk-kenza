<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'log_type',
        'action',
        'loggable_type',
        'loggable_id',
        'old_data',
        'new_data',
        'ip_address',
        'user_agent',
    ];
    
    // Relasi ke pengguna yang melakukan aksi
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // Relasi polimorfik ke objek yang dilog
    public function loggable()
    {
        return $this->morphTo();
    }
}