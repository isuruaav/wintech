@extends('layouts.app')
@section('title', 'Gallery')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="text-center mb-10">
        <h1 class="section-title mb-3">Photo <span>Gallery</span></h1>
        <p class="text-slate-500 max-w-xl mx-auto">Memorable moments from WinTech Institute events and activities.</p>
    </div>

    @if($albums->isEmpty())
    <div class="text-center py-20 bg-white rounded-2xl border border-slate-100">
        <i class="fa-solid fa-images text-5xl text-slate-200 mb-4"></i>
        <p class="text-slate-400">No albums yet.</p>
    </div>
    @else
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($albums as $album)
        <a href="{{ route('gallery.show', $album) }}" class="card-hover group bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-100 reveal">
            <div class="relative h-52 overflow-hidden bg-navy-100">
                <img src="{{ $album->cover_url }}" alt="{{ $album->title }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 bg-navy-950/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                    <span class="bg-white text-navy-900 font-bold px-4 py-2 rounded-xl text-sm">View Album</span>
                </div>
                <span class="absolute top-3 right-3 bg-navy-900/80 text-white text-xs px-3 py-1 rounded-full">
                    {{ $album->images->count() }} photos
                </span>
            </div>
            <div class="p-4">
                <h3 class="font-bold text-navy-900">{{ $album->title }}</h3>
                @if($album->description)<p class="text-slate-500 text-sm mt-1 line-clamp-1">{{ $album->description }}</p>@endif
            </div>
        </a>
        @endforeach
    </div>
    @endif
</div>
@endsection