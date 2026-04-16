@extends('layouts.admin')
@section('title','Edit Paper')
@section('page_title','Edit Paper')
@section('breadcrumb','Papers / Edit')

@section('content')
<div class="max-w-lg">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <form action="{{ route('admin.papers.update', $paper) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-semibold text-navy-900 mb-1.5">Title *</label>
                <input type="text" name="title" value="{{ old('title', $paper->title) }}" class="form-input" required>
            </div>
            <div class="grid sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Subject</label>
                    <input type="text" name="subject" value="{{ old('subject', $paper->subject) }}" class="form-input">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Grade</label>
                    <input type="text" name="grade" value="{{ old('grade', $paper->grade) }}" class="form-input">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Year</label>
                    <input type="number" name="year" value="{{ old('year', $paper->year) }}" class="form-input">
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-navy-900 mb-1.5">Replace PDF <span class="text-slate-400 font-normal">(optional)</span></label>
                <div class="flex items-center gap-3 mb-2">
                    <a href="{{ $paper->file_url }}" target="_blank" class="text-xs text-navy-600 hover:text-gold-500 flex items-center gap-1">
                        <i class="fa-solid fa-file-pdf text-red-500"></i> View current file
                    </a>
                </div>
                <input type="file" name="file" accept=".pdf" class="form-input">
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="active" value="1" {{ old('is_active', $paper->is_active) ? 'checked' : '' }} class="rounded">
                <label for="active" class="text-sm font-medium text-navy-900">Active</label>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">Update Paper</button>
                <a href="{{ route('admin.papers.index') }}" class="px-4 py-2 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 text-sm font-medium">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection