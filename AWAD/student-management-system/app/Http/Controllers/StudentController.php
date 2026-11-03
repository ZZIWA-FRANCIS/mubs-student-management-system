<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller {
    public function index() {
        $students = User::role('Student')->get();
        return view('students.index', compact('students'));
    }

    public function create() {
        return view('students.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'student_number' => 'required|string|unique:users,student_number',
            'password' => 'required|min:8',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);
        $user->assignRole('Student');

        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }

    public function destroy(User $student) {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student removed successfully.');
    }
}