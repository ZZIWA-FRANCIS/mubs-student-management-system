@extends('layouts.app')

@section('content')
<div class="min-h-[70vh] flex flex-col justify-center items-center px-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl border border-slate-200 p-8">
        
        <!-- Header / Logo -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-600 text-white rounded-2xl shadow-lg mb-3">
                <i class="fa-solid fa-graduation-cap text-3xl"></i>
            </div>
            <h2 class="text-2xl font-black text-slate-900 tracking-tight">Welcome Back</h2>
            <p class="text-xs text-slate-500 mt-1 font-medium">MUBS Student Management System</p>
        </div>

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Email Address</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                        class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none transition @error('email') border-rose-500 @enderror"
                        placeholder="e.g. admin@mubs.ac.ug">
                </div>
                @error('email')
                    <p class="text-xs text-rose-500 mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none transition @error('password') border-rose-500 @enderror"
                        placeholder="••••••••">
                </div>
                @error('password')
                    <p class="text-xs text-rose-500 mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center space-x-2 cursor-pointer text-slate-600">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}
                        class="w-4 h-4 text-blue-600 rounded border-slate-300 focus:ring-blue-500">
                    <span>Remember Me</span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="font-semibold text-blue-600 hover:text-blue-800 transition">
                        Forgot Password?
                    </a>
                @endif
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full py-3.5 px-4 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-bold text-sm rounded-xl shadow-lg shadow-blue-500/30 transition duration-200">
                Sign In to Portal
            </button>
        </form>

        <!-- Register Redirection Option -->
        @if (Route::has('register'))
            <div class="mt-6 text-center">
                <p class="text-xs text-slate-500">
                    Don't have an account yet? 
                    <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:text-blue-800 hover:underline transition">
                        Register Here
                    </a>
                </p>
            </div>
        @endif

        <!-- Quick Demo Credentials Hint -->
        <div class="mt-6 pt-6 border-t border-slate-100 text-center">
            <p class="text-xs text-slate-400">
                Default password for seeded accounts: <span class="font-bold text-slate-600">password123</span>
            </p>
        </div>
    </div>
</div>
@endsection