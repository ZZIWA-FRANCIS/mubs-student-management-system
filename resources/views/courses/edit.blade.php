@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <a href="{{ route('courses.index') }}" class="inline-flex items-center text-xs font-bold text-blue-600 hover:text-blue-800 transition">
            <i class="fa-solid fa-arrow-left mr-2"></i> Back to Course Directory
        </a>
        <h1 class="text-3xl font-black text-slate-900 tracking-tight mt-2">Edit Course</h1>
    </div>

    <div class="bg-white rounded-2xl shadow-xl border border-slate-200 p-8">
        <form action="{{ route('courses.update', $course->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Course Code</label>
                    <input type="text" name="code" value="{{ old('code', $course->code) }}" required
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-sm uppercase">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Course Title</label>
                    <input type="text" name="title" value="{{ old('title', $course->title) }}" required
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-sm">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Assign Lecturer</label>
                <select name="lecturer_id" class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-sm">
                    <option value="">-- Unassigned --</option>
                    @foreach($lecturers as $lecturer)
                        <option value="{{ $lecturer->id }}" {{ $course->lecturer_id == $lecturer->id ? 'selected' : '' }}>
                            {{ $lecturer->name }} ({{ $lecturer->email }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Course Description</label>
                <textarea name="description" rows="4" class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-sm">{{ old('description', $course->description) }}</textarea>
            </div>

            <div class="flex items-center justify-end space-x-4 pt-4 border-t border-slate-100">
                <a href="{{ route('courses.index') }}" class="px-5 py-2.5 text-xs font-bold text-slate-500">Cancel</a>
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white text-xs font-bold rounded-xl shadow-lg">Save Changes</button>
            </div>
        </form>
    </div>
</div>
@endsection