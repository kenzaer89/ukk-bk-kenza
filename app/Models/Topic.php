<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = ['name','description'];

    public function sessions()
    {
        return $this->belongsToMany(CounselingSession::class, 'session_topic', 'topic_id', 'session_id');
    }
}
