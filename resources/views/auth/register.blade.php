@extends('layouts.app')

@section('content')
<div class="min-h-[70vh] flex flex-col justify-center items-center px-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl border border-slate-200 p-8">
        
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-600 text-white rounded-2xl shadow-lg mb-3">
                <i class="fa-solid fa-user-plus text-2xl"></i>
            </div>
            <h2 class="text-2xl font-black text-slate-900 tracking-tight">Create Account</h2>
            <p class="text-xs text-slate-500 mt-1 font-medium">Join MUBS Student Management Portal</p>
        </div>

        <!-- Registration Form -->
        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <!-- Full Name -->
            <div>
                <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Full Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-600 outline-none transition @error('name') border-rose-500 @enderror"
                    placeholder="e.g. Sarah Namukasa">
                @error('name')
                    <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-600 outline-none transition @error('email') border-rose-500 @enderror"
                    placeholder="e.g. student@mubs.ac.ug">
                @error('email')
                    <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Password</label>
                <input id="password" type="password" name="password" required
                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-600 outline-none transition @error('password') border-rose-500 @enderror"
                    placeholder="Minimum 8 characters">
                @error('password')
                    <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password-confirm" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Confirm Password</label>
                <input id="password-confirm" type="password" name="password_confirmation" required
                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-600 outline-none transition"
                    placeholder="Repeat password">
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-blue-500/30 transition duration-200 mt-2">
                Complete Registration
            </button>
        </form>

        <!-- Back to Login -->
        <div class="mt-6 text-center">
            <p class="text-xs text-slate-500">
                Already have an account? 
                <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:text-blue-800 hover:underline transition">
                    Sign In Here
                </a>
            </p>
        </div>

    </div>
</div>
@endsection