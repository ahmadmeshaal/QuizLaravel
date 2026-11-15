<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lecturer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'employee_number',
        'department',
        'academic_rank',
        'office_room',
        'photo',
        'isActivated',
    ];

    protected $casts = [
        'isActivated' => 'boolean',
    ];

    // One-to-One
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // One-to-Many
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
