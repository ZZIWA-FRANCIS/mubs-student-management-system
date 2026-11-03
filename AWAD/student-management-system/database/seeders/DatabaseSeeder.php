<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Course;
use App\Models\Registration;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        $this->call(RoleAndPermissionSeeder::class);

        // 1. Create Administrator
        $admin = User::firstOrCreate(
            ['email' => 'admin@mubs.ac.ug'],
            ['name' => 'System Admin', 'password' => Hash::make('password123')]
        );
        $admin->assignRole('Administrator');

        // 2. Create Lecturers
        $lecturer1 = User::firstOrCreate(
            ['email' => 'jdoe@mubs.ac.ug'],
            ['name' => 'Dr. John Doe', 'password' => Hash::make('password123')]
        );
        $lecturer1->assignRole('Lecturer');

        $lecturer2 = User::firstOrCreate(
            ['email' => 'msmith@mubs.ac.ug'],
            ['name' => 'Prof. Mary Smith', 'password' => Hash::make('password123')]
        );
        $lecturer2->assignRole('Lecturer');

        // 3. Create 5 Students
        $students = [];
        for ($i = 1; $i <= 5; $i++) {
            $student = User::firstOrCreate(
                ['email' => "student{$i}@mubs.ac.ug"],
                [
                    'name' => "Student {$i}",
                    'student_number' => "26007000" . $i,
                    'password' => Hash::make('password123')
                ]
            );
            $student->assignRole('Student');
            $students[] = $student;
        }

        // 4. Create 4 Courses
        $c1 = Course::firstOrCreate(['code' => 'BUC3131'], ['title' => 'Advanced Web Application Development', 'lecturer_id' => $lecturer1->id]);
        $c2 = Course::firstOrCreate(['code' => 'BUC3132'], ['title' => 'Database Management Systems II', 'lecturer_id' => $lecturer1->id]);
        $c3 = Course::firstOrCreate(['code' => 'BUC3133'], ['title' => 'Systems Analysis & Design', 'lecturer_id' => $lecturer2->id]);
        $c4 = Course::firstOrCreate(['code' => 'BUC3134'], ['title' => 'E-Commerce Technology', 'lecturer_id' => $lecturer2->id]);

        // 5. Seed Registrations
        Registration::firstOrCreate([
            'user_id' => $students[0]->id,
            'course_id' => $c1->id,
            'academic_year' => '2026/2027',
            'semester' => 'I'
        ]);

        Registration::firstOrCreate([
            'user_id' => $students[1]->id,
            'course_id' => $c1->id,
            'academic_year' => '2026/2027',
            'semester' => 'I'
        ]);
    }
}