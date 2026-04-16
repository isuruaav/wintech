@extends('layouts.admin')
@section('title','Upload File')
@section('page_title','Upload File')
@section('breadcrumb','Downloads / Upload')

@section('content')
<div class="max-w-lg">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <form action="{{ route('admin.downloads.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-navy-900 mb-1.5">Title *</label>
                <input type="text" name="title" value="{{ old('title') }}" class="form-input" required>
            </div>
            <div>
                <label class="block text-sm font-semibold text-navy-900 mb-1.5">Category</label>
                <input type="text" name="category" value="{{ old('category') }}" class="form-input" placeholder="Notes, Templates...">
            </div>
            <div>
                <label class="block text-sm font-semibold text-navy-900 mb-1.5">Description</label>
                <textarea name="description" rows="2" class="form-input resize-none">{{ old('description') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-semibold text-navy-900 mb-1.5">File *</label>
                <input type="file" name="file" class="form-input" required>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="active" value="1" checked class="rounded">
                <label for="active" class="text-sm font-medium text-navy-900">Active</label>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">Upload File</button>
                <a href="{{ route('admin.downloads.index') }}" class="px-4 py-2 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 text-sm font-medium">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection