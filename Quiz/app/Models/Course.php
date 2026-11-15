<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'lecturer_id',
        'course_code',
        'title',
        'credit_hours',
        'semester',
    ];

    // Many-to-One
    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class);
    }

    // One-to-Many
    public function lectures()
    {
        return $this->hasMany(Lecture::class);
    }

    // Many-to-Many
    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('id', 'enrollment_date', 'grade')
            ->withTimestamps();
    }
}
