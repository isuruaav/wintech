@extends('layouts.app')
@section('title', 'Downloads')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="text-center mb-10">
        <h1 class="section-title mb-3">Free <span>Downloads</span></h1>
        <p class="text-slate-500 max-w-xl mx-auto">Download study materials, notes and resources for free.</p>
    </div>

    @if($downloads->isEmpty())
    <div class="text-center py-20 bg-white rounded-2xl border border-slate-100">
        <i class="fa-solid fa-folder-open text-5xl text-slate-200 mb-4"></i>
        <p class="text-slate-400">No downloads available yet.</p>
    </div>
    @else
    <div class="grid sm:grid-cols-2 gap-4">
        @foreach($downloads as $dl)
        <div class="card-hover bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex items-center gap-4 reveal">
            <div class="w-12 h-12 bg-navy-100 rounded-xl flex items-center justify-center shrink-0">
                <i class="fa-solid fa-file-arrow-down text-navy-600 text-xl"></i>
            </div>
            <div class="flex-1 min-w-0">
                @if($dl->category)<span class="text-xs text-navy-500 font-semibold uppercase">{{ $dl->category }}</span>@endif
                <h3 class="font-bold text-navy-900 truncate">{{ $dl->title }}</h3>
                @if($dl->description)<p class="text-slate-500 text-xs mt-0.5 line-clamp-1">{{ $dl->description }}</p>@endif
            </div>
            <a href="{{ $dl->file_url }}" target="_blank"
                class="shrink-0 w-9 h-9 bg-navy-900 hover:bg-gold-500 text-white rounded-xl flex items-center justify-center transition-colors">
                <i class="fa-solid fa-download text-sm"></i>
            </a>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection