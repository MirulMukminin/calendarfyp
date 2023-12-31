<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use HasFactory;
    protected $fillable = ['course_code', 'week', 'course_id', 'date', 'key', 'lecturer_id', 'event_time'];
}
