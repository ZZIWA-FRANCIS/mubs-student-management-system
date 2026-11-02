<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model {
    use HasFactory;

    protected $fillable = ['code', 'title', 'description', 'lecturer_id'];

    // Course belongs to a Lecturer (User)
    public function lecturer() {
        return $this->belongsTo(User::class, 'lecturer_id');
    }

    // Course has many registrations
    public function registrations() {
        return $this->hasMany(Registration::class);
    }

    // Course belongs to many registered Students (Users)
    public function students() {
        return $this->belongsToMany(User::class, 'registrations')
                    ->withPivot('academic_year', 'semester')
                    ->withTimestamps();
    }
}