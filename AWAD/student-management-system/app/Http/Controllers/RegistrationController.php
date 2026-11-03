<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller {
    public function index() {
        $user = Auth::user();

        if ($user->hasRole('Administrator')) {
            $registrations = Registration::with(['user', 'course'])->get();
        } elseif ($user->hasRole('Student')) {
            // Student views only their own registrations [Question 3e]
            $registrations = Registration::where('user_id', $user->id)->with('course')->get();
        } else {
            // Lecturer sees registrations for their taught courses
            $registrations = Registration::whereHas('course', function ($q) use ($user) {
                $q->where('lecturer_id', $user->id);
            })->with(['user', 'course'])->get();
        }

        return view('registrations.index', compact('registrations'));
    }

    public function store(Request $request) {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'academic_year' => 'required|string',
            'semester' => 'required|string',
        ]);

        $userId = Auth::user()->hasRole('Student') ? Auth::id() : $request->input('user_id');

        // Check for duplicate registration [Question 1d & 4c]
        $exists = Registration::where('user_id', $userId)
            ->where('course_id', $request->course_id)
            ->where('academic_year', $request->academic_year)
            ->where('semester', $request->semester)
            ->exists();

        if ($exists) {
            return back()->with('error', 'You are already registered for this course in this semester.');
        }

        Registration::create([
            'user_id' => $userId,
            'course_id' => $request->course_id,
            'academic_year' => $request->academic_year,
            'semester' => $request->semester,
        ]);

        return redirect()->route('registrations.index')->with('success', 'Successfully registered for course.');
    }
}