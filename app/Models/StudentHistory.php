<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentHistory extends Model
{
    use HasFactory;

    protected $fillable = ['student_id','type','description','event_date'];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
