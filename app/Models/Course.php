<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_code',
        'course_name',
        'occ',
        'lecturer',
        'type',
        'time_start',
        'time_end',
        'day',
        'semester',
        'session',
        'lecturer_id'

    ];

    public function user()
    {
        return $this->belongsToMany(User::class, 'schedules', 'user_id', 'course_id');
    }
}
