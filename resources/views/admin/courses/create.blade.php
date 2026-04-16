@extends('layouts.admin')
@section('title','Add Course')
@section('page_title','Add Course')
@section('breadcrumb','Courses / Create')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <form action="{{ route('admin.courses.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <div class="grid sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Course Title *</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="form-input" required>
                    @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Category</label>
                    <select name="category_id" class="form-input">
                        <option value="">— Select —</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Level</label>
                    <select name="level" class="form-input">
                        <option value="">— Select —</option>
                        @foreach(['Beginner','Intermediate','Advanced'] as $lvl)
                        <option value="{{ $lvl }}" {{ old('level') === $lvl ? 'selected' : '' }}>{{ $lvl }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Duration</label>
                    <input type="text" name="duration" value="{{ old('duration') }}" class="form-input" placeholder="3 Months">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Fee (Rs.)</label>
                    <input type="number" name="fee" value="{{ old('fee') }}" class="form-input" placeholder="5000">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Description</label>
                    <textarea name="description" rows="3" class="form-input resize-none">{{ old('description') }}</textarea>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Syllabus</label>
                    <textarea name="syllabus" rows="5" class="form-input resize-none" placeholder="List topics covered...">{{ old('syllabus') }}</textarea>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Course Image</label>
                    <input type="file" name="image" accept="image/*" data-preview="img-preview" class="form-input">
                    <img id="img-preview" class="hidden mt-3 w-32 h-20 object-cover rounded-xl border border-slate-200">
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_featured" id="featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="rounded">
                    <label for="featured" class="text-sm font-medium text-navy-900">Featured Course</label>
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" id="active" value="1" checked class="rounded">
                    <label for="active" class="text-sm font-medium text-navy-900">Active</label>
                </div>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">Save Course</button>
                <a href="{{ route('admin.courses.index') }}" class="px-4 py-2 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 text-sm font-medium">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection