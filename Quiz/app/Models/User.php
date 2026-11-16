<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // One-to-One
    public function lecturer()
    {
        return $this->hasOne(Lecturer::class);
    }

    // Many-to-Many
    public function courses()
    {
        return $this->belongsToMany(Course::class)
            ->withPivot('id', 'enrollment_date', 'grade')
            ->withTimestamps();
    }
}
