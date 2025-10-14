<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CounselingRequest extends Model
{
    use HasFactory;

    protected $table = 'counseling_requests';

    protected $fillable = [
        'id_user',      // requester (student)
        'reason',
        'status',       // pending/approved/rejected
        'requested_at',
        'admin_notes',
    ];

    protected $dates = [
        'requested_at',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
