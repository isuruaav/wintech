@extends('layouts.admin')
@section('title','Add Grade Class')
@section('page_title','Add New Grade Class')
@section('breadcrumb','Grade Classes / New')

@section('content')
<div class="max-w-3xl">
    <form action="{{ route('admin.classes.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 space-y-5">
            <h3 class="font-bold text-navy-900 text-sm uppercase tracking-wide">Class Details</h3>
            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Grade *</label>
                    <select name="grade" class="form-input" required>
                        <option value="">Select Grade</option>
                        @foreach($grades as $g)
                        <option value="{{ $g }}" {{ old('grade') == $g ? 'selected' : '' }}>{{ $g }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Subject *</label>
                    <select name="subject" class="form-input" required>
                        <option value="">Select Subject</option>
                        @foreach($subjects as $s)
                        <option value="{{ $s }}" {{ old('subject') == $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Teacher Name *</label>
                    <input type="text" name="teacher" value="{{ old('teacher') }}" class="form-input" required placeholder="e.g. Mr. Kasun Perera">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Teaching Medium *</label>
                    <select name="medium" class="form-input" required>
                        <option value="sinhala" {{ old('medium') === 'sinhala' ? 'selected' : '' }}>Sinhala Medium</option>
                        <option value="english" {{ old('medium') === 'english' ? 'selected' : '' }}>English Medium</option>
                        <option value="both"    {{ old('medium','both') === 'both' ? 'selected' : '' }}>Both Mediums</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Class Mode *</label>
                    <select name="mode" class="form-input" required>
                        <option value="both"     {{ old('mode','both') === 'both'     ? 'selected' : '' }}>Physical + Online</option>
                        <option value="physical" {{ old('mode') === 'physical' ? 'selected' : '' }}>Physical Only</option>
                        <option value="online"   {{ old('mode') === 'online'   ? 'selected' : '' }}>Online Only</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Monthly Fee (Rs.)</label>
                    <input type="number" name="monthly_fee" value="{{ old('monthly_fee') }}" class="form-input" placeholder="0.00" min="0" step="0.01">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="form-input" min="0">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Description</label>
                    <textarea name="description" rows="3" class="form-input resize-none" placeholder="Short description...">{{ old('description') }}</textarea>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Thumbnail Image</label>
                    <input type="file" name="thumbnail" accept="image/*" class="form-input py-2 text-sm">
                </div>
                <div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" checked class="rounded border-slate-300">
                        <span class="text-sm font-medium text-navy-900">Active</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-navy-900 text-sm uppercase tracking-wide">Class Schedule (Day &amp; Time)</h3>
                <button type="button" id="add-schedule-btn"
                        class="text-xs font-medium text-navy-600 hover:text-navy-800 flex items-center gap-1 px-3 py-1.5 rounded-lg bg-navy-50 hover:bg-navy-100 transition-colors">
                    <i class="fa-solid fa-plus text-xs"></i> Add Time Slot
                </button>
            </div>

            <div id="schedules-container" class="space-y-3">
                <div class="schedule-row grid sm:grid-cols-4 gap-3 items-end">
                    <div>
                        <label class="block text-xs font-semibold text-navy-700 mb-1">Day</label>
                        <select name="schedules[0][day]" class="form-input py-2 text-sm">
                            <option value="">Select Day</option>
                            @foreach($days as $d)
                            <option value="{{ $d }}">{{ $d }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-navy-700 mb-1">Start Time</label>
                        <input type="time" name="schedules[0][start_time]" class="form-input py-2 text-sm" value="08:00">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-navy-700 mb-1">End Time</label>
                        <input type="time" name="schedules[0][end_time]" class="form-input py-2 text-sm" value="10:00">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-navy-700 mb-1">Venue (optional)</label>
                        <input type="text" name="schedules[0][venue]" class="form-input py-2 text-sm" placeholder="e.g. Room 3">
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="btn-primary">
                <i class="fa-solid fa-check"></i> Save Class
            </button>
            <a href="{{ route('admin.classes.index') }}" class="px-5 py-2.5 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 text-sm font-medium transition-colors">
                Cancel
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
let scheduleIndex = 1;
const days = @json($days);

document.getElementById('add-schedule-btn').addEventListener('click', function () {
    const container = document.getElementById('schedules-container');
    const row = document.createElement('div');
    row.className = 'schedule-row grid sm:grid-cols-4 gap-3 items-end';
    row.innerHTML = `
        <div>
            <label class="block text-xs font-semibold text-navy-700 mb-1">Day</label>
            <select name="schedules[${scheduleIndex}][day]" class="form-input py-2 text-sm">
                <option value="">Select Day</option>
                ${days.map(d => `<option value="${d}">${d}</option>`).join('')}
            </select>
        </div>
        <div>
            <label class="block text-xs font-semibold text-navy-700 mb-1">Start Time</label>
            <input type="time" name="schedules[${scheduleIndex}][start_time]" class="form-input py-2 text-sm" value="08:00">
        </div>
        <div>
            <label class="block text-xs font-semibold text-navy-700 mb-1">End Time</label>
            <input type="time" name="schedules[${scheduleIndex}][end_time]" class="form-input py-2 text-sm" value="10:00">
        </div>
        <div class="flex gap-2">
            <div class="flex-1">
                <label class="block text-xs font-semibold text-navy-700 mb-1">Venue</label>
                <input type="text" name="schedules[${scheduleIndex}][venue]" class="form-input py-2 text-sm" placeholder="e.g. Room 3">
            </div>
            <button type="button" onclick="this.closest('.schedule-row').remove()"
                    class="w-8 h-8 mb-0 self-end bg-red-50 hover:bg-red-100 text-red-500 rounded-lg flex items-center justify-center shrink-0">
                <i class="fa-solid fa-xmark text-xs"></i>
            </button>
        </div>`;
    container.appendChild(row);
    scheduleIndex++;
});
</script>
@endpush
@endsection