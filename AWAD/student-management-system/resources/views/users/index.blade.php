@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row justify-between sm:items-center bg-white p-6 rounded-2xl border border-slate-200 shadow-sm mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">User & Role Management</h1>
            <p class="text-xs text-slate-500 mt-1">Assign roles (Administrator, Lecturer, Student) and manage system access.</p>
        </div>
        <div class="text-xs font-bold text-slate-500 bg-slate-100 px-4 py-2 rounded-xl">
            Total System Users: <span class="text-blue-600 font-extrabold">{{ $users->total() }}</span>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold rounded-xl flex items-center justify-between">
            <span><i class="fa-solid fa-circle-check mr-2"></i> {{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 text-xs font-bold rounded-xl flex items-center justify-between">
            <span><i class="fa-solid fa-circle-exclamation mr-2"></i> {{ session('error') }}</span>
        </div>
    @endif

    <!-- Users Table Card -->
    <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-slate-700 font-bold uppercase text-[11px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3.5 px-6">User</th>
                        <th class="py-3.5 px-6">Email Address</th>
                        <th class="py-3.5 px-6">Current Role</th>
                        <th class="py-3.5 px-6">Assign New Role</th>
                        <th class="py-3.5 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($users as $user)
                        <tr class="hover:bg-slate-50/80 transition">
                            <!-- Name & Avatar -->
                            <td class="py-4 px-6 font-bold text-slate-900 flex items-center space-x-3">
                                <div class="w-9 h-9 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-black text-xs">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <span class="block leading-snug">{{ $user->name }}</span>
                                    <span class="text-[10px] text-slate-400 font-medium">ID: #{{ $user->id }}</span>
                                </div>
                            </td>

                            <!-- Email -->
                            <td class="py-4 px-6 text-slate-600 font-medium text-xs">{{ $user->email }}</td>

                            <!-- Current Role Badge -->
                            <td class="py-4 px-6">
                                @forelse($user->roles as $role)
                                    @if($role->name === 'Administrator')
                                        <span class="px-3 py-1 bg-purple-100 text-purple-800 text-xs font-extrabold rounded-lg inline-flex items-center">
                                            <i class="fa-solid fa-shield-halved mr-1 text-[10px]"></i> Administrator
                                        </span>
                                    @elseif($role->name === 'Lecturer')
                                        <span class="px-3 py-1 bg-indigo-100 text-indigo-800 text-xs font-extrabold rounded-lg inline-flex items-center">
                                            <i class="fa-solid fa-chalkboard-user mr-1 text-[10px]"></i> Lecturer
                                        </span>
                                    @else
                                        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-extrabold rounded-lg inline-flex items-center">
                                            <i class="fa-solid fa-user-graduate mr-1 text-[10px]"></i> Student
                                        </span>
                                    @endif
                                @empty
                                    <span class="px-2.5 py-1 bg-slate-100 text-slate-500 text-xs font-bold rounded-lg">No Role</span>
                                @endforelse
                            </td>

                            <!-- Assign Role Form -->
                            <td class="py-4 px-6">
                                <form action="{{ route('users.updateRole', $user->id) }}" method="POST" class="flex items-center space-x-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="role" class="px-3 py-1.5 bg-slate-50 border border-slate-300 rounded-xl text-xs font-semibold focus:ring-2 focus:ring-blue-600 outline-none">
                                        @foreach($roles as $role)
                                            <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="px-3 py-1.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-xl shadow transition">
                                        Save
                                    </button>
                                </form>
                            </td>

                            <!-- Actions -->
                            <td class="py-4 px-6 text-right">
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg transition" title="Delete User">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                @else
                                    <span class="text-[11px] font-bold text-slate-400 italic">Current Admin</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection