@extends('layouts.admin')
@section('title', 'Edit Exam')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <div class="flex items-center gap-3">
        <a href="{{ route('admin.exams.index') }}" class="text-slate-400 hover:text-navy-700">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-navy-900">Edit Exam</h1>
    </div>

    <form method="POST" action="{{ route('admin.exams.update', $exam) }}"
          class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-5">
        @csrf @method('PUT')

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Exam Name <span class="text-red-500">*</span></label>
            <input type="text" name="title" value="{{ old('title', $exam->title) }}"
                   class="form-input w-full rounded-xl border-slate-200">
            @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Subject <span class="text-red-500">*</span></label>
                <select name="subject" class="form-input w-full rounded-xl border-slate-200">
                    <option value="">— Select —</option>
                    @foreach(['ICT','English','Mathematics','Science'] as $s)
                    <option value="{{ $s }}" {{ old('subject',$exam->subject)==$s?'selected':'' }}>{{ $s }}</option>
                    @endforeach
                </select>
                @error('subject') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Grade <span class="text-red-500">*</span></label>
                <select name="grade" class="form-input w-full rounded-xl border-slate-200">
                    <option value="">— Select —</option>
                    @foreach($grades as $g)
                    <option value="{{ $g }}" {{ old('grade',$exam->grade)==$g?'selected':'' }}>Grade {{ $g }}</option>
                    @endforeach
                </select>
                @error('grade') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Exam Type</label>
                <select name="type" class="form-input w-full rounded-xl border-slate-200">
                    <option value="term_test" {{ old('type',$exam->type)=='term_test'?'selected':'' }}>Term Test</option>
                    <option value="mid_year"  {{ old('type',$exam->type)=='mid_year'?'selected':'' }}>Mid Year</option>
                    <option value="final"     {{ old('type',$exam->type)=='final'?'selected':'' }}>Final Exam</option>
                    <option value="mock"      {{ old('type',$exam->type)=='mock'?'selected':'' }}>Mock Exam</option>
                    <option value="other"     {{ old('type',$exam->type)=='other'?'selected':'' }}>Other</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Exam Date</label>
                <input type="date" name="exam_date"
                       value="{{ old('exam_date', $exam->exam_date?->format('Y-m-d')) }}"
                       class="form-input w-full rounded-xl border-slate-200">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Total Marks <span class="text-red-500">*</span></label>
                <input type="number" name="total_marks" value="{{ old('total_marks', $exam->total_marks) }}"
                       min="1" max="1000" class="form-input w-full rounded-xl border-slate-200">
                @error('total_marks') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Pass Marks <span class="text-red-500">*</span></label>
                <input type="number" name="pass_marks" value="{{ old('pass_marks', $exam->pass_marks) }}"
                       min="1" max="1000" class="form-input w-full rounded-xl border-slate-200">
                @error('pass_marks') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Grade Class (Optional)</label>
            <select name="grade_class_id" class="form-input w-full rounded-xl border-slate-200">
                <option value="">— None —</option>
                @foreach($gradeClasses as $gc)
                <option value="{{ $gc->id }}" {{ old('grade_class_id',$exam->grade_class_id)==$gc->id?'selected':'' }}>
                    {{ $gc->subject }} — Grade {{ $gc->grade }}
                    @if($gc->teacher_name) ({{ $gc->teacher_name }}) @endif
                </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Description</label>
            <textarea name="description" rows="2"
                      class="form-input w-full rounded-xl border-slate-200">{{ old('description', $exam->description) }}</textarea>
        </div>

        <div class="flex items-center gap-2">
            <input type="hidden" name="is_published" value="0">
            <input type="checkbox" name="is_published" value="1" id="is_published"
                   class="w-4 h-4 rounded border-slate-300 text-navy-600"
                   {{ old('is_published', $exam->is_published) ? 'checked' : '' }}>
            <label for="is_published" class="text-sm font-medium text-slate-700">Published (visible to students)</label>
        </div>

        <div class="flex gap-3 pt-2 border-t border-slate-100">
            <button type="submit" class="btn-primary">
                <i class="fa-solid fa-save"></i> Update
            </button>
            <a href="{{ route('admin.exams.index') }}" class="btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection