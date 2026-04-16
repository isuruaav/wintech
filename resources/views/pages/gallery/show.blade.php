@extends('layouts.app')
@section('title', $album->title)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <nav class="flex items-center gap-2 text-sm text-slate-400 mb-6">
        <a href="{{ route('gallery.index') }}" class="hover:text-navy-700">Gallery</a>
        <i class="fa-solid fa-chevron-right text-xs"></i>
        <span class="text-navy-700">{{ $album->title }}</span>
    </nav>

    <div class="mb-8">
        <h1 class="text-2xl font-extrabold text-navy-900">{{ $album->title }}</h1>
        @if($album->description)<p class="text-slate-500 mt-1">{{ $album->description }}</p>@endif
        <p class="text-slate-400 text-sm mt-1">{{ $album->images->count() }} photos</p>
    </div>

    @if($album->images->isEmpty())
    <div class="text-center py-16 bg-white rounded-2xl border border-slate-100">
        <i class="fa-solid fa-images text-4xl text-slate-200 mb-4"></i>
        <p class="text-slate-400">No images in this album.</p>
    </div>
    @else
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
        @foreach($album->images as $image)
        <div class="gallery-item aspect-square reveal" data-src="{{ $image->url }}">
            <img src="{{ $image->url }}" alt="{{ $image->caption ?? $album->title }}"
                class="w-full h-full object-cover rounded-xl">
        </div>
        @endforeach
    </div>
    @endif

    <div class="mt-6">
        <a href="{{ route('gallery.index') }}" class="btn-primary text-sm">
            <i class="fa-solid fa-arrow-left"></i> Back to Gallery
        </a>
    </div>
</div>
@endsection