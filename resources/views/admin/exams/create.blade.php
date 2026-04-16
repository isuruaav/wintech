@extends('layouts.admin')
@section('title','Create Exam')
@section('page_title','Create Exam')
@section('breadcrumb','Exams / Create')

@section('content')
<div class="max-w-lg">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <form action="{{ route('admin.exams.store') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-navy-900 mb-1.5">Grade Class *</label>
                <select name="grade_class_id" class="form-input" required>
                    <option value="">— Select Class —</option>
                    @foreach($classes as $class)
                    <option value="{{ $class->id }}" {{ old('grade_class_id') == $class->id ? 'selected' : '' }}>
                        {{ $class->full_name }}
                    </option>
                    @endforeach
                </select>
                @error('grade_class_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-navy-900 mb-1.5">Exam Title *</label>
                <input type="text" name="title" value="{{ old('title') }}" class="form-input" placeholder="e.g. Term 1 Exam 2024" required>
            </div>
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Total Marks *</label>
                    <input type="number" name="total_marks" value="{{ old('total_marks', 100) }}" class="form-input" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Exam Date</label>
                    <input type="date" name="exam_date" value="{{ old('exam_date') }}" class="form-input">
                </div>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">Create Exam</button>
                <a href="{{ route('admin.exams.index') }}" class="px-4 py-2 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 text-sm font-medium">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection