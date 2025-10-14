<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Violation extends Model
{
    use HasFactory;

    protected $table = 'violations';

    protected $fillable = [
        'student_id',
        'rule_id',
        'occurred_at',
        'notes',
        'points',
    ];

    protected $dates = ['occurred_at'];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function rule()
    {
        return $this->belongsTo(Rule::class, 'rule_id');
    }
}
