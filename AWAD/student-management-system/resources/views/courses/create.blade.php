@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Back Header -->
    <div class="mb-6">
        <a href="{{ route('courses.index') }}" class="inline-flex items-center text-xs font-bold text-blue-600 hover:text-blue-800 transition">
            <i class="fa-solid fa-arrow-left mr-2"></i> Back to Course Directory
        </a>
        <h1 class="text-3xl font-black text-slate-900 tracking-tight mt-2">Create New Course</h1>
        <p class="text-xs text-slate-500 mt-1">Add a new academic module to the MUBS database and assign a lecturer.</p>
    </div>

    <!-- Create Course Form Card -->
    <div class="bg-white rounded-2xl shadow-xl border border-slate-200 p-8">
        <form action="{{ route('courses.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Course Code & Title Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="code" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Course Code</label>
                    <input type="text" name="code" id="code" value="{{ old('code') }}" required
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-600 outline-none transition uppercase @error('code') border-rose-500 @enderror"
                        placeholder="e.g. BUC3133">
                    @error('code')
                        <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Course Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-600 outline-none transition @error('title') border-rose-500 @enderror"
                        placeholder="e.g. Cloud Computing & DevOps">
                    @error('title')
                        <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Assigned Lecturer Selection -->
            <div>
                <label for="lecturer_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Assign Lecturer</label>
                <div class="relative">
                    <select name="lecturer_id" id="lecturer_id"
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-600 outline-none transition appearance-none">
                        <option value="">-- Select Assigned Lecturer (Optional) --</option>
                        @foreach($lecturers as $lecturer)
                            <option value="{{ $lecturer->id }}" {{ old('lecturer_id') == $lecturer->id ? 'selected' : '' }}>
                                {{ $lecturer->name }} ({{ $lecturer->email }})
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </div>
                </div>
                @error('lecturer_id')
                    <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Course Description -->
            <div>
                <label for="description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Course Description</label>
                <textarea name="description" id="description" rows="4"
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-600 outline-none transition"
                    placeholder="Provide a brief overview of course objectives and syllabus content...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end space-x-4 pt-4 border-t border-slate-100">
                <a href="{{ route('courses.index') }}" class="px-5 py-2.5 text-xs font-bold text-slate-500 hover:text-slate-700 transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-lg shadow-blue-500/30 transition">
                    <i class="fa-solid fa-plus mr-1.5"></i> Save Course
                </button>
            </div>
        </form>
    </div>
</div>
@endsection