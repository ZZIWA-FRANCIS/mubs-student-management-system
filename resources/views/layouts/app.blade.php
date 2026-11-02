<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MUBS SMS') }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome Icons CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>
<body class="h-full text-slate-800 antialiased flex flex-col justify-between">

    <!-- Top Navigation Bar -->
    <nav class="bg-slate-900 border-b border-slate-800 text-white sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                
                <!-- Brand / Logo -->
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
                    <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center font-black text-white shadow-md shadow-blue-500/20 group-hover:scale-105 transition">
                        <i class="fa-solid fa-graduation-cap text-lg"></i>
                    </div>
                    <div>
                        <span class="font-extrabold text-lg tracking-tight text-white block leading-none">MUBS SMS</span>
                        <span class="text-[10px] text-blue-400 font-semibold tracking-wider uppercase">Makerere University Business School</span>
                    </div>
                </a>

                <!-- Navigation Links & Auth Actions -->
                <div class="flex items-center space-x-3 sm:space-x-4">
                    @guest
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-300 hover:text-white transition">Login</a>
                        @endif
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-sm font-bold bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-xl shadow-md transition">Register</a>
                        @endif
                    @else
                        <!-- All Roles: Available Courses Directory -->
                        <a href="{{ route('courses.index') }}" class="text-xs font-semibold text-slate-300 hover:text-white bg-slate-800 hover:bg-slate-700/80 px-3 py-2 rounded-xl border border-slate-700 transition flex items-center space-x-1.5">
                            <i class="fa-solid fa-book-open text-blue-400"></i>
                            <span class="hidden sm:inline">Available Courses</span>
                        </a>

                        <!-- Student Only: My Enrolled Courses -->
                        @role('Student')
                            <a href="{{ route('registrations.index') }}" class="text-xs font-extrabold bg-emerald-600/20 text-emerald-400 hover:bg-emerald-600 hover:text-white border border-emerald-500/30 px-3 py-2 rounded-xl transition flex items-center space-x-1.5">
                                <i class="fa-solid fa-circle-check"></i>
                                <span>My Enrolled Courses</span>
                            </a>
                        @endrole

                        <!-- Lecturer Only: Course Registrations -->
                        @role('Lecturer')
                            <a href="{{ route('registrations.index') }}" class="text-xs font-extrabold bg-indigo-600/20 text-indigo-400 hover:bg-indigo-600 hover:text-white border border-indigo-500/30 px-3 py-2 rounded-xl transition flex items-center space-x-1.5">
                                <i class="fa-solid fa-clipboard-user"></i>
                                <span>Student Registrations</span>
                            </a>
                        @endrole

                        <!-- Administrator Only: Manage Users -->
                        @role('Administrator')
                            <a href="{{ route('users.index') }}" class="text-xs font-extrabold bg-blue-600/20 text-blue-400 hover:bg-blue-600 hover:text-white border border-blue-500/30 px-3 py-2 rounded-xl transition flex items-center space-x-1.5">
                                <i class="fa-solid fa-users-gear"></i>
                                <span>Manage Users</span>
                            </a>
                        @endrole

                        <!-- User Profile & Status Badges -->
                        <div class="flex items-center space-x-2 border-l border-slate-800 pl-3">
                            <span class="text-xs font-bold bg-slate-800 text-slate-300 px-3 py-1.5 rounded-xl border border-slate-700 flex items-center space-x-1.5">
                                <i class="fa-solid fa-user-check text-blue-400"></i>
                                <span>{{ Auth::user()->name }}</span>
                                
                                @if(Auth::user()->hasRole('Administrator'))
                                    <span class="text-[9px] uppercase font-black bg-purple-500/20 text-purple-300 px-1.5 py-0.5 rounded border border-purple-500/30 ml-1">Admin</span>
                                @elseif(Auth::user()->hasRole('Lecturer'))
                                    <span class="text-[9px] uppercase font-black bg-indigo-500/20 text-indigo-300 px-1.5 py-0.5 rounded border border-indigo-500/30 ml-1">Lecturer</span>
                                @else
                                    <span class="text-[9px] uppercase font-black bg-emerald-500/20 text-emerald-300 px-1.5 py-0.5 rounded border border-emerald-500/30 ml-1">Student</span>
                                @endif
                            </span>

                            <!-- Logout Action -->
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                               class="text-xs font-bold text-rose-400 hover:text-rose-300 bg-rose-500/10 hover:bg-rose-500/20 px-3 py-2 rounded-xl border border-rose-500/20 transition flex items-center space-x-1"
                               title="Logout">
                                <i class="fa-solid fa-right-from-bracket"></i>
                                <span class="hidden sm:inline">Logout</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        </div>
                    @endguest
                </div>

            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main class="py-10 flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-500">
        <p>&copy; {{ date('Y') }} Makerere University Business School • BUC3131 Advanced Web Application Development</p>
    </footer>

</body>
</html>