<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root URL to Login page
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes (Login, Register, Password Reset)
Auth::routes();

// Authenticated System Routes
Route::middleware(['auth'])->group(function () {

    // Dashboard / Course Directory
    Route::get('/dashboard', [CourseController::class, 'index'])->name('dashboard');

    // Course Resource Routes (index, create, store, show, edit, update, destroy)
    Route::resource('courses', CourseController::class);

    // Course Registration Routes (Students / Lecturers / Admin)
    Route::get('/registrations', [RegistrationController::class, 'index'])->name('registrations.index');
    Route::post('/registrations', [RegistrationController::class, 'store'])->name('registrations.store');

    // User & Role Management Routes (Administrator Only)
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.updateRole');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

});