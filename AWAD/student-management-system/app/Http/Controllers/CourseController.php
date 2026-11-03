<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of courses based on user role.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('Lecturer')) {
            // Lecturers view only their assigned courses
            $courses = Course::where('lecturer_id', $user->id)
                ->withCount('registrations')
                ->with('lecturer')
                ->get();
        } else {
            // Administrator and Students view all courses
            $courses = Course::withCount('registrations')
                ->with('lecturer')
                ->get();
        }

        return view('courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new course (Admin only).
     */
    public function create()
    {
        if (!auth()->user()->hasRole('Administrator')) {
            abort(403, 'Unauthorized action. Only Administrators can create courses.');
        }

        $lecturers = User::role('Lecturer')->get();
        return view('courses.create', compact('lecturers'));
    }

    /**
     * Store a newly created course in database (Admin only).
     */
    public function store(Request $request)
    {
        if (!auth()->user()->hasRole('Administrator')) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'code'        => 'required|string|max:20|unique:courses,code',
            'title'       => 'required|string|max:255',
            'lecturer_id' => 'nullable|exists:users,id',
            'description' => 'nullable|string',
        ]);

        Course::create($validated);

        return redirect()->route('courses.index')->with('success', 'New course created successfully!');
    }

    /**
     * Display the specified course and its registered student roster.
     */
    public function show(Course $course)
    {
        $user = auth()->user();

        // If user is a Lecturer, restrict access to only their assigned course
        if ($user->hasRole('Lecturer') && $course->lecturer_id !== $user->id) {
            abort(403, 'Unauthorized action. You are not assigned to this course.');
        }

        // Eager load registered students and assigned lecturer
        $course->load(['registrations.user', 'lecturer']);

        return view('courses.show', compact('course'));
    }

    /**
     * Show the form for editing an existing course (Admin only).
     */
    public function edit(Course $course)
    {
        if (!auth()->user()->hasRole('Administrator')) {
            abort(403, 'Unauthorized action. Only Administrators can edit courses.');
        }

        $lecturers = User::role('Lecturer')->get();
        return view('courses.edit', compact('course', 'lecturers'));
    }

    /**
     * Update the specified course in database (Admin only).
     */
    public function update(Request $request, Course $course)
    {
        if (!auth()->user()->hasRole('Administrator')) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'code'        => 'required|string|max:20|unique:courses,code,' . $course->id,
            'title'       => 'required|string|max:255',
            'lecturer_id' => 'nullable|exists:users,id',
            'description' => 'nullable|string',
        ]);

        $course->update($validated);

        return redirect()->route('courses.index')->with('success', 'Course details updated successfully!');
    }

    /**
     * Remove the specified course from database (Admin only).
     */
    public function destroy(Course $course)
    {
        if (!auth()->user()->hasRole('Administrator')) {
            abort(403, 'Unauthorized action. Only Administrators can delete courses.');
        }

        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
    }
}