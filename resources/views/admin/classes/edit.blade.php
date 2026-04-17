@extends('layouts.admin')
@section('title','Edit Grade Class')
@section('page_title','Edit Grade Class')
@section('breadcrumb','Grade Classes / Edit')

@section('content')
<div class="max-w-3xl space-y-5">

    <form action="{{ route('admin.classes.update', $class) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 space-y-5">
            <h3 class="font-bold text-navy-900 text-sm uppercase tracking-wide">Class Details</h3>
            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Grade *</label>
                    <select name="grade" class="form-input" required>
                        @foreach($grades as $g)
                        <option value="{{ $g }}" {{ $class->grade == $g ? 'selected' : '' }}>{{ $g }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Subject *</label>
                    <select name="subject" class="form-input" required>
                        @foreach($subjects as $s)
                        <option value="{{ $s }}" {{ $class->subject == $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
               <div class="sm:col-span-2">
    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Teacher *</label>
    <select name="teacher_id" class="form-input" required>
        <option value="">Select Teacher</option>
        @foreach($teachers as $t)
        <option value="{{ $t->id }}" {{ $class->teacher_id == $t->id ? 'selected' : '' }}>
            {{ $t->name }} @if($t->subjects) — {{ $t->subjects }} @endif
        </option>
        @endforeach
    </select>
    <p class="text-xs text-slate-400 mt-1">
        <a href="{{ route('admin.teachers.create') }}" target="_blank" class="text-navy-600 hover:underline">Add New Teacher →</a>
    </p>
</div>
                <div>
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Teaching Medium *</label>
                    <select name="medium" class="form-input" required>
                        <option value="sinhala" {{ $class->medium === 'sinhala' ? 'selected' : '' }}>Sinhala Medium</option>
                        <option value="english" {{ $class->medium === 'english' ? 'selected' : '' }}>English Medium</option>
                        <option value="both"    {{ $class->medium === 'both'    ? 'selected' : '' }}>Both Mediums</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Class Mode *</label>
                    <select name="mode" class="form-input" required>
                        <option value="both"     {{ $class->mode === 'both'     ? 'selected' : '' }}>Physical + Online</option>
                        <option value="physical" {{ $class->mode === 'physical' ? 'selected' : '' }}>Physical Only</option>
                        <option value="online"   {{ $class->mode === 'online'   ? 'selected' : '' }}>Online Only</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Monthly Fee (Rs.)</label>
                    <input type="number" name="monthly_fee" value="{{ old('monthly_fee', $class->monthly_fee) }}" class="form-input" min="0" step="0.01">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $class->sort_order) }}" class="form-input" min="0">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Description</label>
                    <textarea name="description" rows="3" class="form-input resize-none">{{ old('description', $class->description) }}</textarea>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Thumbnail Image</label>
                    @if($class->thumbnail)
                    <div class="mb-3">
                        <img src="{{ Storage::url($class->thumbnail) }}" class="w-32 h-20 rounded-xl object-cover border border-slate-200" alt="">
                    </div>
                    @endif
                    <input type="file" name="thumbnail" accept="image/*" class="form-input py-2 text-sm">
                </div>
                <div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ $class->is_active ? 'checked' : '' }} class="rounded border-slate-300">
                        <span class="text-sm font-medium text-navy-900">Active</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-3 mt-5">
            <button type="submit" class="btn-primary">
                <i class="fa-solid fa-check"></i> Update Class
            </button>
            <a href="{{ route('admin.classes.index') }}" class="px-5 py-2.5 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 text-sm font-medium transition-colors">Cancel</a>
        </div>
    </form>

    {{-- Schedules --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <h3 class="font-bold text-navy-900 text-sm uppercase tracking-wide mb-4">
            <i class="fa-regular fa-calendar text-navy-400 mr-1"></i> Class Schedule (Day &amp; Time)
        </h3>

        @if($schedules->count())
        <div class="space-y-2 mb-4">
            @foreach($schedules as $s)
            <div class="flex items-center justify-between bg-navy-50 rounded-xl px-4 py-3">
                <div class="flex items-center gap-4 text-sm">
                    <span class="font-medium text-navy-900 w-28">{{ $s->day }}</span>
                    <span class="text-slate-600">
                        {{ \Carbon\Carbon::parse($s->start_time)->format('h:i A') }}
                        &ndash;
                        {{ \Carbon\Carbon::parse($s->end_time)->format('h:i A') }}
                    </span>
                    @if($s->venue)
                    <span class="text-slate-400 text-xs"><i class="fa-solid fa-location-dot mr-1"></i>{{ $s->venue }}</span>
                    @endif
                </div>
                <form action="{{ route('admin.classes.schedule.remove', [$class, $s]) }}" method="POST">
                    @csrf @method('DELETE')
                    <button data-confirm="Remove this schedule?"
                            class="w-7 h-7 bg-red-50 hover:bg-red-100 text-red-500 rounded-lg flex items-center justify-center">
                        <i class="fa-solid fa-xmark text-xs"></i>
                    </button>
                </form>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-sm text-slate-400 mb-4">No schedules yet.</p>
        @endif

        <form action="{{ route('admin.classes.schedule.add', $class) }}" method="POST">
            @csrf
            <div class="grid sm:grid-cols-4 gap-3 items-end border-t border-slate-100 pt-4">
                <div>
                    <label class="block text-xs font-semibold text-navy-700 mb-1">Day *</label>
                    <select name="day" class="form-input py-2 text-sm" required>
                        <option value="">Select Day</option>
                        @foreach($days as $d)
                        <option value="{{ $d }}">{{ $d }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-navy-700 mb-1">Start Time *</label>
                    <input type="time" name="start_time" class="form-input py-2 text-sm" value="08:00" required>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-navy-700 mb-1">End Time *</label>
                    <input type="time" name="end_time" class="form-input py-2 text-sm" value="10:00" required>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-navy-700 mb-1">Venue</label>
                    <div class="flex gap-2">
                        <input type="text" name="venue" class="form-input py-2 text-sm flex-1" placeholder="e.g. Room 3">
                        <button type="submit" class="btn-primary py-2 px-3 shrink-0 text-xs">
                            <i class="fa-solid fa-plus"></i> Add
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection