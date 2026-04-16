@extends('layouts.admin')
@section('title','Add Video')
@section('page_title','Add Video')
@section('breadcrumb','Videos / Create')

@section('content')
<div class="max-w-xl">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <form action="{{ route('admin.videos.store') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-navy-900 mb-1.5">Title *</label>
                <input type="text" name="title" value="{{ old('title') }}" class="form-input" required>
            </div>
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Source *</label>
                    <select name="source" class="form-input" required>
                        <option value="youtube"  {{ old('source') === 'youtube'  ? 'selected' : '' }}>YouTube</option>
                        <option value="facebook" {{ old('source') === 'facebook' ? 'selected' : '' }}>Facebook</option>
                        <option value="upload"   {{ old('source') === 'upload'   ? 'selected' : '' }}>Upload</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Category</label>
                    <input type="text" name="category" value="{{ old('category') }}" class="form-input" placeholder="e.g. ICT, Tutorial">
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-navy-900 mb-1.5">Video URL *</label>
                <input type="text" name="video_url" value="{{ old('video_url') }}" class="form-input" placeholder="https://youtube.com/watch?v=..." required>
            </div>
            <div>
                <label class="block text-sm font-semibold text-navy-900 mb-1.5">Description</label>
                <textarea name="description" rows="3" class="form-input resize-none">{{ old('description') }}</textarea>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="active" value="1" checked class="rounded">
                <label for="active" class="text-sm font-medium text-navy-900">Active</label>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">Add Video</button>
                <a href="{{ route('admin.videos.index') }}" class="px-4 py-2 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 text-sm font-medium">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection