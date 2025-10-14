<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointLevel extends Model
{
    use HasFactory;

    protected $fillable = ['point_threshold','action'];
}
