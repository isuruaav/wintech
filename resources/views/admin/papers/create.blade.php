@extends('layouts.admin')
@section('title','Upload Paper')
@section('page_title','Upload Paper')
@section('breadcrumb','Papers / Upload')

@section('content')
<div class="max-w-lg">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <form action="{{ route('admin.papers.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-navy-900 mb-1.5">Title *</label>
                <input type="text" name="title" value="{{ old('title') }}" class="form-input" required>
            </div>
            <div class="grid sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Subject</label>
                    <input type="text" name="subject" value="{{ old('subject') }}" class="form-input" placeholder="ICT">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Grade</label>
                    <input type="text" name="grade" value="{{ old('grade') }}" class="form-input" placeholder="O/L">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Year</label>
                    <input type="number" name="year" value="{{ old('year') }}" class="form-input" placeholder="2023">
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-navy-900 mb-1.5">PDF File *</label>
                <input type="file" name="file" accept=".pdf" class="form-input" required>
                @error('file')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="active" value="1" checked class="rounded">
                <label for="active" class="text-sm font-medium text-navy-900">Active</label>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">Upload Paper</button>
                <a href="{{ route('admin.papers.index') }}" class="px-4 py-2 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 text-sm font-medium">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection