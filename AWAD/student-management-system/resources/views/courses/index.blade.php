@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
    
    <!-- Flash Messages -->
    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold rounded-2xl flex items-center justify-between shadow-sm">
            <span><i class="fa-solid fa-circle-check mr-2 text-emerald-600 text-sm"></i> {{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 text-xs font-bold rounded-2xl flex items-center justify-between shadow-sm">
            <span><i class="fa-solid fa-circle-exclamation mr-2 text-rose-600 text-sm"></i> {{ session('error') }}</span>
        </div>
    @endif

    <!-- Header Banner -->
    <div class="flex flex-col sm:flex-row justify-between sm:items-center bg-white p-6 rounded-2xl border border-slate-200 shadow-sm gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Available Course Directory</h1>
            <p class="text-xs text-slate-500 mt-1">
                @role('Administrator') Manage university course offerings and lecturer assignments. @endrole
                @role('Lecturer') Course modules assigned to you for teaching and student evaluation. @endrole
                @role('Student') Select and register for available academic courses for this term. @endrole
            </p>
        </div>

        <div class="flex items-center gap-3">
            @role('Student')
                <a href="{{ route('registrations.index') }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold text-xs rounded-xl border border-emerald-200 transition gap-2">
                    <i class="fa-solid fa-graduation-cap"></i> View My Enrolled Courses
                </a>
            @endrole

            @can('manage courses')
                <a href="{{ route('courses.create') }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-md transition gap-2">
                    <i class="fa-solid fa-plus"></i> Add New Course
                </a>
            @endcan
        </div>
    </div>

    <!-- Course Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($courses as $course)
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition p-6 flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-start mb-3">
                        <span class="px-3 py-1 bg-slate-100 text-slate-700 text-xs font-extrabold rounded-lg uppercase tracking-wider">
                            {{ $course->code }}
                        </span>
                        
                        @hasanyrole('Lecturer|Administrator')
                            <a href="{{ route('courses.show', $course->id) }}" class="px-2.5 py-1 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-semibold rounded-full border border-indigo-200 transition flex items-center space-x-1">
                                <i class="fa-solid fa-users text-[10px]"></i>
                                <span>{{ $course->registrations_count ?? $course->registrations->count() }} Registered Students</span>
                            </a>
                        @endhasanyrole
                    </div>

                    <h3 class="text-lg font-bold text-slate-900 mb-2">
                        @hasanyrole('Lecturer|Administrator')
                            <a href="{{ route('courses.show', $course->id) }}" class="hover:text-blue-600 transition">
                                {{ $course->title }}
                            </a>
                        @else
                            {{ $course->title }}
                        @endhasanyrole
                    </h3>

                    <p class="text-slate-600 text-xs line-clamp-2 mb-4">
                        {{ $course->description ?? 'No course description provided for this course module.' }}
                    </p>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-between items-center text-xs text-slate-500">
                    <div class="flex items-center space-x-2">
                        <i class="fa-solid fa-user-tie text-slate-400"></i>
                        <span>{{ $course->lecturer->name ?? 'Unassigned' }}</span>
                    </div>

                    <!-- Student Modal Registration Action -->
                    @role('Student')
                        <div x-data="{ open: false }">
                            <button @click="open = true" type="button" class="px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-sm transition flex items-center gap-1.5">
                                <i class="fa-solid fa-pen-to-square"></i> Register
                            </button>

                            <!-- Registration Modal -->
                            <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4">
                                <div @click.away="open = false" class="bg-white rounded-2xl p-6 max-w-md w-full shadow-2xl border border-slate-200 text-left">
                                    <div class="flex justify-between items-center mb-4 pb-3 border-b border-slate-100">
                                        <h3 class="text-base font-black text-slate-900">Course Registration</h3>
                                        <button @click="open = false" type="button" class="text-slate-400 hover:text-slate-600">
                                            <i class="fa-solid fa-xmark text-lg"></i>
                                        </button>
                                    </div>

                                    <form action="{{ route('registrations.store') }}" method="POST" class="space-y-4">
                                        @csrf
                                        <input type="hidden" name="course_id" value="{{ $course->id }}">

                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Selected Course</label>
                                            <input type="text" value="{{ $course->code }} - {{ $course->title }}" readonly class="w-full px-3 py-2 bg-slate-100 border border-slate-200 rounded-xl text-xs font-bold text-slate-700">
                                        </div>

                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Academic Year</label>
                                            <select name="academic_year" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs font-semibold focus:ring-2 focus:ring-blue-600 outline-none">
                                                <option value="2026/2027">2026/2027</option>
                                                <option value="2025/2026">2025/2026</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Semester</label>
                                            <select name="semester" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs font-semibold focus:ring-2 focus:ring-blue-600 outline-none">
                                                <option value="I">Semester I</option>
                                                <option value="II">Semester II</option>
                                            </select>
                                        </div>

                                        <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
                                            <button type="button" @click="open = false" class="px-4 py-2 text-xs font-bold text-slate-500 hover:text-slate-700">Cancel</button>
                                            <button type="submit" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-md transition">Confirm Registration</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endrole

                    @hasanyrole('Lecturer|Administrator')
                        <a href="{{ route('courses.show', $course->id) }}" class="font-bold text-blue-600 hover:text-blue-800 flex items-center space-x-1">
                            <span>View Roster</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    @endhasanyrole
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white p-12 text-center rounded-2xl border border-dashed border-slate-300">
                <i class="fa-solid fa-folder-open text-4xl text-slate-300 mb-3"></i>
                <p class="text-slate-500 font-medium text-xs">No course modules available at the moment.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection