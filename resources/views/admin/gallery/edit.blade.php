@extends('layouts.admin')
@section('title','Edit Album')
@section('page_title','Edit Album')
@section('breadcrumb','Gallery / Edit')

@section('content')
<div class="max-w-2xl space-y-5">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <form action="{{ route('admin.gallery.update', $gallery) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-semibold text-navy-900 mb-1.5">Album Title *</label>
                <input type="text" name="title" value="{{ old('title', $gallery->title) }}" class="form-input" required>
            </div>
            <div>
                <label class="block text-sm font-semibold text-navy-900 mb-1.5">Description</label>
                <textarea name="description" rows="2" class="form-input resize-none">{{ old('description', $gallery->description) }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-semibold text-navy-900 mb-1.5">Add More Photos</label>
                <input type="file" name="images[]" multiple accept="image/*" class="form-input">
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="active" value="1" {{ old('is_active', $gallery->is_active) ? 'checked' : '' }} class="rounded">
                <label for="active" class="text-sm font-medium text-navy-900">Active</label>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">Update Album</button>
                <a href="{{ route('admin.gallery.index') }}" class="px-4 py-2 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 text-sm font-medium">Cancel</a>
            </div>
        </form>
    </div>

    @if($gallery->images->count())
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <h3 class="font-bold text-navy-900 mb-4">Current Photos ({{ $gallery->images->count() }})</h3>
        <div class="grid grid-cols-3 sm:grid-cols-4 gap-3">
            @foreach($gallery->images as $img)
            <div class="relative group aspect-square">
                <img src="{{ $img->url }}" class="w-full h-full object-cover rounded-xl border border-slate-100" alt="">
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection