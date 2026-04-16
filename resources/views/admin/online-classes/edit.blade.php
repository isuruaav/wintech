@extends('layouts.admin')
@section('title','Edit Online Class')
@section('page_title','Edit Online Class')
@section('breadcrumb','Online Classes / Edit')

@section('content')
<div class="max-w-xl">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <form action="{{ route('admin.online-classes.update', $onlineClass) }}" method="POST" class="space-y-5">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-semibold text-navy-900 mb-1.5">Title *</label>
                <input type="text" name="title" value="{{ old('title', $onlineClass->title) }}" class="form-input" required>
            </div>
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Grade Class</label>
                    <select name="grade_class_id" class="form-input">
                        <option value="">— Select —</option>
                        @foreach($gradeClasses as $gc)
                        <option value="{{ $gc->id }}" {{ old('grade_class_id', $onlineClass->grade_class_id) == $gc->id ? 'selected' : '' }}>{{ $gc->full_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Platform *</label>
                    <select name="platform" class="form-input" required>
                        <option value="google_meet" {{ old('platform', $onlineClass->platform) === 'google_meet' ? 'selected' : '' }}>Google Meet</option>
                        <option value="zoom"        {{ old('platform', $onlineClass->platform) === 'zoom'        ? 'selected' : '' }}>Zoom</option>
                        <option value="other"       {{ old('platform', $onlineClass->platform) === 'other'       ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Scheduled At *</label>
                    <input type="datetime-local" name="scheduled_at" value="{{ old('scheduled_at', $onlineClass->scheduled_at->format('Y-m-d\TH:i')) }}" class="form-input" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Duration (minutes)</label>
                    <input type="number" name="duration_minutes" value="{{ old('duration_minutes', $onlineClass->duration_minutes) }}" class="form-input" required>
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-navy-900 mb-1.5">Join URL *</label>
                <input type="url" name="join_url" value="{{ old('join_url', $onlineClass->join_url) }}" class="form-input" required>
            </div>
            <div>
                <label class="block text-sm font-semibold text-navy-900 mb-1.5">Description</label>
                <textarea name="description" rows="3" class="form-input resize-none">{{ old('description', $onlineClass->description) }}</textarea>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="active" value="1" {{ old('is_active', $onlineClass->is_active) ? 'checked' : '' }} class="rounded">
                <label for="active" class="text-sm font-medium text-navy-900">Active</label>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">Update Class</button>
                <a href="{{ route('admin.online-classes.index') }}" class="px-4 py-2 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 text-sm font-medium">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection