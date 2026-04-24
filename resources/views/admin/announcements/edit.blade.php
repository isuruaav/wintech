@extends('layouts.admin')

@section('title', 'Edit Announcement')
@section('page_title', 'Edit Announcement')

@section('content')
<div class="max-w-2xl">
    <form action="{{ route('admin.announcements.update', $announcement) }}" method="POST" enctype="multipart/form-data"
          class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 space-y-5">
        @csrf @method('PUT')

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Title <span class="text-red-500">*</span></label>
            <input type="text" name="title" value="{{ old('title', $announcement->title) }}"
                   class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-blue-500">
            @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Type</label>
                <select name="type" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach(['general','exam','event','holiday','urgent'] as $t)
                    <option value="{{ $t }}" {{ old('type', $announcement->type) === $t ? 'selected' : '' }}>
                        {{ ucfirst($t) }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                <select name="is_active" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="1" {{ old('is_active', $announcement->is_active) ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ !old('is_active', $announcement->is_active) ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Start Date</label>
                <input type="date" name="start_date" value="{{ old('start_date', $announcement->start_date?->format('Y-m-d')) }}"
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">End Date</label>
                <input type="date" name="end_date" value="{{ old('end_date', $announcement->end_date?->format('Y-m-d')) }}"
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Content <span class="text-red-500">*</span></label>
            <textarea name="content" rows="5"
                      class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-blue-500 resize-none">{{ old('content', $announcement->content) }}</textarea>
            @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Image</label>
            @if($announcement->image)
                <img src="{{ Storage::url($announcement->image) }}" class="w-32 h-20 object-cover rounded-xl mb-2">
            @endif
            <input type="file" name="image" accept="image/*"
                   class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm outline-none">
        </div>

        <div class="flex justify-end gap-3 pt-2">
            <a href="{{ route('admin.announcements.index') }}"
               class="px-5 py-2.5 text-sm text-slate-500 hover:text-slate-700 rounded-xl border border-slate-200 hover:bg-slate-50">
                Cancel
            </a>
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-6 py-2.5 rounded-xl">
                <i class="fa-solid fa-floppy-disk mr-1"></i> Update
            </button>
        </div>
    </form>
</div>
@endsection