<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a list of all users and their roles (Admin only).
     */
    public function index()
    {
        if (!auth()->user()->hasRole('Administrator')) {
            abort(403, 'Unauthorized action. Only Administrators can manage users.');
        }

        $users = User::with('roles')->paginate(15);
        $roles = Role::all();

        return view('users.index', compact('users', 'roles'));
    }

    /**
     * Update user role (Admin only).
     */
    public function updateRole(Request $request, User $user)
    {
        if (!auth()->user()->hasRole('Administrator')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        // Sync new role (replaces existing role)
        $user->syncRoles([$request->role]);

        return redirect()->back()->with('success', "Role for {$user->name} updated to {$request->role} successfully.");
    }

    /**
     * Delete a user (Admin only).
     */
    public function destroy(User $user)
    {
        if (!auth()->user()->hasRole('Administrator')) {
            abort(403, 'Unauthorized action.');
        }

        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->back()->with('success', 'User account deleted successfully.');
    }
}