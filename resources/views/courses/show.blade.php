@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Back Button & Course Details Header -->
    <div class="mb-8">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-xs font-bold text-blue-600 hover:text-blue-800 mb-4 transition">
            <i class="fa-solid fa-arrow-left mr-2"></i> Back to Course Directory
        </a>
        <div class="flex items-center justify-between">
            <div>
                <span class="text-xs font-extrabold text-blue-600 uppercase tracking-widest">{{ $course->code }}</span>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">{{ $course->title }}</h1>
            </div>
            <span class="bg-blue-100 text-blue-800 font-extrabold text-xs px-4 py-2 rounded-xl">
                {{ $course->registrations->count() }} Enrolled Students
            </span>
        </div>
    </div>

    <!-- Student Roster Table -->
    <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-slate-900 text-base">Registered Class Roster</h3>
            <span class="text-xs text-slate-400 font-medium">Academic Year 2026/2027</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-slate-700 font-bold uppercase text-[11px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3.5 px-6">#</th>
                        <th class="py-3.5 px-6">Student Name</th>
                        <th class="py-3.5 px-6">Student Number</th>
                        <th class="py-3.5 px-6">Email Address</th>
                        <th class="py-3.5 px-6">Registration Period</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($course->registrations as $index => $registration)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-4 px-6 font-bold text-slate-400">{{ $index + 1 }}</td>
                            <td class="py-4 px-6 font-bold text-slate-900 flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-black text-xs">
                                    {{ substr($registration->user->name, 0, 1) }}
                                </div>
                                <span>{{ $registration->user->name }}</span>
                            </td>
                            <td class="py-4 px-6 font-mono text-xs font-semibold text-slate-600">
                                {{ $registration->user->student_number ?? '2026/BUC/' . (100 + $registration->user->id) }}
                            </td>
                            <td class="py-4 px-6 text-slate-500">{{ $registration->user->email }}</td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center text-xs font-semibold text-slate-700 bg-slate-100 px-2.5 py-1 rounded-lg">
                                    {{ $registration->academic_year }} • Sem {{ $registration->semester }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-400 font-medium">
                                No students registered for this course module yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection