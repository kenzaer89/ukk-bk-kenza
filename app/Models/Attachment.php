<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = ['session_id','filename','path','mime_type','size_bytes','uploaded_at'];

    public function session()
    {
        return $this->belongsTo(CounselingSession::class, 'session_id');
    }
}
