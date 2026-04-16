@extends('layouts.admin')
@section('title','Add Album')
@section('page_title','Add Album')
@section('breadcrumb','Gallery / Create')

@section('content')
<div class="max-w-xl">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-navy-900 mb-1.5">Album Title *</label>
                <input type="text" name="title" value="{{ old('title') }}" class="form-input" required>
            </div>
            <div>
                <label class="block text-sm font-semibold text-navy-900 mb-1.5">Description</label>
                <textarea name="description" rows="2" class="form-input resize-none">{{ old('description') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-semibold text-navy-900 mb-1.5">Upload Photos</label>
                <input type="file" name="images[]" multiple accept="image/*" class="form-input">
                <p class="text-xs text-slate-400 mt-1">You can select multiple images at once.</p>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="active" value="1" checked class="rounded">
                <label for="active" class="text-sm font-medium text-navy-900">Active (visible on website)</label>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">Create Album</button>
                <a href="{{ route('admin.gallery.index') }}" class="px-4 py-2 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 text-sm font-medium">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection