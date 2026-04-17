@extends('layouts.admin')
@section('title','Edit Teacher')
@section('page_title','Edit Teacher')
@section('breadcrumb','Teachers / Edit')

@section('content')
<div class="max-w-2xl">
    <form action="{{ route('admin.teachers.update', $teacher) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf @method('PUT')
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 space-y-5">
            <div class="grid sm:grid-cols-2 gap-5">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Full Name *</label>
                    <input type="text" name="name" value="{{ old('name', $teacher->name) }}" class="form-input" required>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Subjects Taught</label>
                    <input type="text" name="subjects" value="{{ old('subjects', $teacher->subjects) }}" class="form-input" placeholder="e.g. ICT, Mathematics">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $teacher->phone) }}" class="form-input">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email', $teacher->email) }}" class="form-input">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Bio / Description</label>
                    <textarea name="bio" rows="3" class="form-input resize-none">{{ old('bio', $teacher->bio) }}</textarea>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Profile Photo</label>
                    @if($teacher->photo)
                    <div class="mb-3 flex items-center gap-3">
                        <img src="{{ Storage::url($teacher->photo) }}" class="w-20 h-20 rounded-full object-cover border border-slate-200" alt="">
                        <p class="text-xs text-slate-400">Current photo. Upload new one to replace.</p>
                    </div>
                    @endif
                    <input type="file" name="photo" accept="image/*" data-preview="photo-preview" class="form-input py-2 text-sm">
                    <img id="photo-preview" src="" class="hidden mt-3 w-24 h-24 rounded-full object-cover border border-slate-200" alt="">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $teacher->sort_order) }}" class="form-input" min="0">
                </div>
                <div class="flex items-end pb-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ $teacher->is_active ? 'checked' : '' }} class="rounded border-slate-300">
                        <span class="text-sm font-medium text-navy-900">Active</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <button type="submit" class="btn-primary">
                <i class="fa-solid fa-check"></i> Update Teacher
            </button>
            <a href="{{ route('admin.teachers.index') }}" class="px-5 py-2.5 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 text-sm font-medium transition-colors">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection