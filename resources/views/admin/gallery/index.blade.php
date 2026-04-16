@extends('layouts.admin')
@section('title','Gallery')
@section('page_title','Gallery')
@section('breadcrumb','Manage photo albums')

@section('content')
<div class="flex items-center justify-between mb-5">
    <p class="text-slate-500 text-sm">{{ $albums->total() }} albums</p>
    <a href="{{ route('admin.gallery.create') }}" class="btn-primary text-sm">
        <i class="fa-solid fa-plus"></i> Add Album
    </a>
</div>

<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
    @forelse($albums as $album)
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="relative h-36 bg-slate-100">
            @if($album->cover_image)
                <img src="{{ asset('storage/'.$album->cover_image) }}" class="w-full h-full object-cover" alt="">
            @else
                <div class="w-full h-full flex items-center justify-center">
                    <i class="fa-solid fa-images text-slate-300 text-4xl"></i>
                </div>
            @endif
            <span class="absolute top-2 right-2 bg-navy-900/80 text-white text-xs px-2.5 py-1 rounded-full">
                {{ $album->images_count }} photos
            </span>
        </div>
        <div class="p-4">
            <h3 class="font-bold text-navy-900 text-sm">{{ $album->title }}</h3>
            @if($album->description)
                <p class="text-slate-400 text-xs mt-0.5 line-clamp-1">{{ $album->description }}</p>
            @endif
            <div class="flex items-center justify-between mt-3">
                <span class="badge {{ $album->is_active ? 'badge-active' : 'badge-inactive' }}">
                    {{ $album->is_active ? 'Active' : 'Hidden' }}
                </span>
                <div class="flex gap-1.5">
                    <a href="{{ route('admin.gallery.edit', $album) }}" class="w-8 h-8 bg-navy-50 hover:bg-navy-100 text-navy-600 rounded-lg flex items-center justify-center">
                        <i class="fa-solid fa-pen text-xs"></i>
                    </a>
                    <form action="{{ route('admin.gallery.destroy', $album) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button data-confirm="Delete album {{ $album->title }}?" class="w-8 h-8 bg-red-50 hover:bg-red-100 text-red-500 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-trash text-xs"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-3 text-center py-16 bg-white rounded-2xl border border-slate-100">
        <i class="fa-solid fa-images text-4xl text-slate-200 mb-3"></i>
        <p class="text-slate-400">No albums yet.</p>
    </div>
    @endforelse
</div>
@if($albums->hasPages())
<div class="mt-4">{{ $albums->links() }}</div>
@endif
@endsection