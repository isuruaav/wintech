@extends('layouts.admin')
@section('title','Edit Download')
@section('page_title','Edit Download')
@section('breadcrumb','Downloads / Edit')

@section('content')
<div class="max-w-lg">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <form action="{{ route('admin.downloads.update', $download) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-semibold text-navy-900 mb-1.5">Title *</label>
                <input type="text" name="title" value="{{ old('title', $download->title) }}" class="form-input" required>
            </div>
            <div>
                <label class="block text-sm font-semibold text-navy-900 mb-1.5">Category</label>
                <input type="text" name="category" value="{{ old('category', $download->category) }}" class="form-input">
            </div>
            <div>
                <label class="block text-sm font-semibold text-navy-900 mb-1.5">Description</label>
                <textarea name="description" rows="2" class="form-input resize-none">{{ old('description', $download->description) }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-semibold text-navy-900 mb-1.5">Replace File <span class="text-slate-400 font-normal">(optional)</span></label>
                <a href="{{ $download->file_url }}" target="_blank" class="text-xs text-navy-600 hover:text-gold-500 flex items-center gap-1 mb-2">
                    <i class="fa-solid fa-file mr-1"></i> View current file
                </a>
                <input type="file" name="file" class="form-input">
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="active" value="1" {{ old('is_active', $download->is_active) ? 'checked' : '' }} class="rounded">
                <label for="active" class="text-sm font-medium text-navy-900">Active</label>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">Update File</button>
                <a href="{{ route('admin.downloads.index') }}" class="px-4 py-2 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 text-sm font-medium">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection