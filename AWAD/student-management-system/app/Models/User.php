<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable {
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name', 'email', 'password', 'student_number',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // Lecturer teaches many courses
    public function taughtCourses() {
        return $this->hasMany(Course::class, 'lecturer_id');
    }

    // Student has many registrations
    public function registrations() {
        return $this->hasMany(Registration::class);
    }

    // Student belongs to many courses through registrations
    public function registeredCourses() {
        return $this->belongsToMany(Course::class, 'registrations')
                    ->withPivot('academic_year', 'semester')
                    ->withTimestamps();
    }
}