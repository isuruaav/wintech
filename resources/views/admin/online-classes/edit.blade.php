@extends('layouts.admin')
@section('title', 'Edit Online Class')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <div class="flex items-center gap-3">
        <a href="{{ route('admin.online-classes.index') }}" class="text-slate-400 hover:text-navy-700">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-navy-900">Edit Online Class</h1>
            <p class="text-slate-500 text-sm">{{ $onlineClass->title }}</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.online-classes.update', $onlineClass) }}"
          class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-5">
        @csrf @method('PUT')

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Title <span class="text-red-500">*</span></label>
            <input type="text" name="title" value="{{ old('title', $onlineClass->title) }}"
                   class="form-input w-full rounded-xl border-slate-200">
            @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Grade Class (Optional)</label>
            <select name="grade_class_id" class="form-input w-full rounded-xl border-slate-200">
                <option value="">— Select Grade Class —</option>
                @foreach($gradeClasses as $gc)
                <option value="{{ $gc->id }}" {{ old('grade_class_id', $onlineClass->grade_class_id) == $gc->id ? 'selected' : '' }}>
                    {{ $gc->subject }} — Grade {{ $gc->grade }}
                    @if($gc->teacher_name) ({{ $gc->teacher_name }}) @endif
                </option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Platform <span class="text-red-500">*</span></label>
                <select name="platform" class="form-input w-full rounded-xl border-slate-200">
                    <option value="google_meet" {{ old('platform',$onlineClass->platform)=='google_meet'?'selected':'' }}>Google Meet</option>
                    <option value="zoom"        {{ old('platform',$onlineClass->platform)=='zoom'?'selected':'' }}>Zoom</option>
                    <option value="teams"       {{ old('platform',$onlineClass->platform)=='teams'?'selected':'' }}>MS Teams</option>
                    <option value="other"       {{ old('platform',$onlineClass->platform)=='other'?'selected':'' }}>Other</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Status <span class="text-red-500">*</span></label>
                <select name="status" class="form-input w-full rounded-xl border-slate-200">
                    <option value="upcoming" {{ old('status',$onlineClass->status)=='upcoming'?'selected':'' }}>Upcoming</option>
                    <option value="live"     {{ old('status',$onlineClass->status)=='live'?'selected':'' }}>Live Now</option>
                    <option value="ended"    {{ old('status',$onlineClass->status)=='ended'?'selected':'' }}>Ended</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Join URL <span class="text-red-500">*</span></label>
            <input type="url" name="join_url" value="{{ old('join_url', $onlineClass->join_url) }}"
                   class="form-input w-full rounded-xl border-slate-200">
            @error('join_url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Date & Time <span class="text-red-500">*</span></label>
                <input type="datetime-local" name="scheduled_at"
                       value="{{ old('scheduled_at', $onlineClass->scheduled_at->format('Y-m-d\TH:i')) }}"
                       class="form-input w-full rounded-xl border-slate-200">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Duration (minutes) <span class="text-red-500">*</span></label>
                <input type="number" name="duration_minutes"
                       value="{{ old('duration_minutes', $onlineClass->duration_minutes) }}"
                       min="15" max="480"
                       class="form-input w-full rounded-xl border-slate-200">
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Description</label>
            <textarea name="description" rows="3"
                      class="form-input w-full rounded-xl border-slate-200">{{ old('description', $onlineClass->description) }}</textarea>
        </div>

        <div class="flex items-center gap-3 pt-2">
            <label class="relative inline-flex items-center cursor-pointer gap-2">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1"
                       class="sr-only peer"
                       {{ old('is_active', $onlineClass->is_active) ? 'checked' : '' }}>
                <div class="w-11 h-6 bg-slate-200 peer-focus:ring-2 peer-focus:ring-navy-300 rounded-full peer peer-checked:bg-navy-600 transition-colors after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-5"></div>
                <span class="text-sm font-medium text-slate-700">Active (visible on site)</span>
            </label>
        </div>

        <div class="flex gap-3 pt-2 border-t border-slate-100">
            <button type="submit" class="btn-primary">
                <i class="fa-solid fa-save"></i> Update Class
            </button>
            <a href="{{ route('admin.online-classes.index') }}" class="btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection