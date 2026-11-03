@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Header Banner -->
    <div class="flex flex-col sm:flex-row justify-between sm:items-center bg-white p-6 rounded-2xl border border-slate-200 shadow-sm mb-8 gap-4">
        <div>
            <span class="text-[11px] font-extrabold uppercase tracking-widest text-blue-600 bg-blue-50 px-3 py-1 rounded-md">
                @role('Student') Student Portal @endrole
                @role('Lecturer') Lecturer Portal @endrole
                @role('Administrator') Admin Portal @endrole
            </span>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight mt-2">
                @role('Student') My Enrolled Courses @endrole
                @role('Lecturer') Student Class Registrations @endrole
                @role('Administrator') All System Registrations @endrole
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                @role('Student') Review active module registrations for your current academic term. @endrole
                @role('Lecturer') Overview of enrolled students across your assigned course modules. @endrole
                @role('Administrator') Complete audit log of all university course registrations. @endrole
            </p>
        </div>
        
        @role('Student')
            <a href="{{ route('courses.index') }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-md shadow-blue-500/20 transition gap-2">
                <i class="fa-solid fa-plus text-xs"></i> Register Additional Courses
            </a>
        @endrole
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold rounded-2xl flex items-center justify-between shadow-sm">
            <span><i class="fa-solid fa-circle-check mr-2 text-emerald-600 text-sm"></i> {{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 text-xs font-bold rounded-2xl flex items-center justify-between shadow-sm">
            <span><i class="fa-solid fa-circle-exclamation mr-2 text-rose-600 text-sm"></i> {{ session('error') }}</span>
        </div>
    @endif

    <!-- Registrations View: Table for Admins/Lecturers, Cards for Students -->
    @hasanyrole('Administrator|Lecturer')
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-slate-700 font-bold uppercase text-[11px] tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="py-3.5 px-6">Student</th>
                            <th class="py-3.5 px-6">Course Code & Title</th>
                            <th class="py-3.5 px-6">Academic Year</th>
                            <th class="py-3.5 px-6">Semester</th>
                            <th class="py-3.5 px-6 text-right">Registration Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($registrations as $registration)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-4 px-6 font-bold text-slate-900 flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-black text-xs">
                                        {{ substr($registration->user->name ?? 'S', 0, 1) }}
                                    </div>
                                    <div>
                                        <span class="block leading-snug">{{ $registration->user->name ?? 'N/A' }}</span>
                                        <span class="text-[10px] text-slate-400 font-normal">{{ $registration->user->email ?? '' }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6 font-medium text-slate-800">
                                    <span class="inline-block px-2 py-0.5 bg-blue-50 text-blue-700 text-[11px] font-bold rounded mr-1.5 uppercase">
                                        {{ $registration->course->code ?? 'N/A' }}
                                    </span>
                                    {{ $registration->course->title ?? 'N/A' }}
                                </td>
                                <td class="py-4 px-6 font-mono text-xs text-slate-600">{{ $registration->academic_year }}</td>
                                <td class="py-4 px-6">
                                    <span class="px-2.5 py-1 bg-slate-100 text-slate-700 font-bold text-xs rounded-lg">
                                        Sem {{ $registration->semester }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-right text-xs text-slate-400 font-medium">
                                    {{ $registration->created_at ? $registration->created_at->format('M d, Y') : 'N/A' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-slate-400 font-medium">
                                    No student registrations recorded yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <!-- Student Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($registrations as $registration)
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-center mb-4">
                            <span class="px-3 py-1 bg-blue-50 text-blue-700 text-xs font-extrabold rounded-lg tracking-wider">
                                {{ $registration->course->code ?? 'N/A' }}
                            </span>
                            <span class="text-[11px] font-bold bg-slate-100 text-slate-600 px-3 py-1 rounded-full">
                                {{ $registration->academic_year }} • Sem {{ $registration->semester }}
                            </span>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 mb-2 leading-snug">
                            {{ $registration->course->title ?? 'N/A' }}
                        </h3>
                        <p class="text-slate-500 text-xs line-clamp-3 mb-6">
                            {{ $registration->course->description ?? 'No course description provided for this module.' }}
                        </p>
                    </div>
                    <div class="pt-4 border-t border-slate-100 flex justify-between items-center text-xs">
                        <div class="flex items-center space-x-2 text-slate-500 font-medium">
                            <i class="fa-solid fa-user-tie text-slate-400"></i>
                            <span>{{ $registration->course->lecturer->name ?? 'Unassigned Lecturer' }}</span>
                        </div>
                        <span class="text-emerald-600 bg-emerald-50 border border-emerald-200 px-3 py-1 rounded-full font-extrabold flex items-center gap-1.5">
                            <i class="fa-solid fa-circle-check text-[10px]"></i> Active Enrollment
                        </span>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white p-12 text-center rounded-2xl border border-dashed border-slate-300 shadow-sm">
                    <i class="fa-solid fa-folder-open text-4xl text-slate-300 mb-3"></i>
                    <h3 class="text-base font-bold text-slate-800 mb-1">No Course Registrations Found</h3>
                    <p class="text-xs text-slate-500 max-w-md mx-auto mb-6">You have not registered for any academic courses yet.</p>
                    <a href="{{ route('courses.index') }}" class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white font-bold text-xs rounded-xl shadow transition">
                        Browse Course Directory
                    </a>
                </div>
            @endforelse
        </div>
    @endhasanyrole
</div>
@endsection