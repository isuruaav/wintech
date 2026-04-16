@extends('layouts.app')
@section('title', 'Online Classes')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="text-center mb-10">
        <h1 class="section-title mb-3">Online <span>Classes</span></h1>
        <p class="text-slate-500 max-w-xl mx-auto">Join live classes via Google Meet or Zoom from anywhere.</p>
    </div>

    {{-- LIVE NOW --}}
    @if($live->count())
    <div class="mb-10">
        <div class="flex items-center gap-3 mb-4">
            <span class="flex items-center gap-2 bg-red-500 text-white text-xs font-bold px-4 py-1.5 rounded-full animate-pulse">
                <span class="w-2 h-2 bg-white rounded-full"></span> LIVE NOW
            </span>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($live as $oc)
            <div class="bg-white rounded-2xl border-2 border-red-400 shadow-sm p-5 reveal">
                <div class="flex items-center gap-2 mb-3">
                    <span class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="fa-solid {{ $oc->platform_icon }} text-red-500 text-sm"></i>
                    </span>
                    <span class="text-xs font-bold text-red-500 uppercase">Live</span>
                </div>
                <h3 class="font-bold text-navy-900 mb-1">{{ $oc->title }}</h3>
                @if($oc->gradeClass)<p class="text-xs text-slate-400 mb-1">{{ $oc->gradeClass->full_name }}</p>@endif
                <p class="text-xs text-slate-400 mb-4"><i class="fa-regular fa-clock mr-1"></i>{{ $oc->duration_minutes }} min</p>
                <a href="{{ $oc->join_url }}" target="_blank" class="flex items-center justify-center gap-2 bg-red-500 hover:bg-red-600 text-white font-bold px-4 py-2.5 rounded-xl text-sm transition-colors w-full">
                    <i class="fa-solid fa-circle-dot animate-pulse"></i> Join Now
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- UPCOMING --}}
    @if($upcoming->count())
    <div class="mb-10">
        <h2 class="text-lg font-bold text-navy-900 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-calendar-days text-gold-500"></i> Upcoming Classes
        </h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($upcoming as $oc)
            <div class="card-hover bg-white rounded-2xl border border-slate-100 shadow-sm p-5 reveal">
                <div class="flex items-center gap-2 mb-3">
                    <span class="w-8 h-8 bg-navy-100 rounded-lg flex items-center justify-center">
                        <i class="fa-solid {{ $oc->platform_icon }} text-navy-600 text-sm"></i>
                    </span>
                    <span class="text-xs font-semibold text-navy-600 capitalize">{{ str_replace('_',' ',$oc->platform) }}</span>
                </div>
                <h3 class="font-bold text-navy-900 mb-1">{{ $oc->title }}</h3>
                @if($oc->gradeClass)<p class="text-xs text-slate-400 mb-1">{{ $oc->gradeClass->full_name }}</p>@endif
                @if($oc->description)<p class="text-xs text-slate-500 mb-3 line-clamp-2">{{ $oc->description }}</p>@endif
                <div class="bg-navy-50 rounded-xl px-4 py-3 mb-4 text-xs text-navy-700">
                    <p><i class="fa-regular fa-calendar mr-1"></i>{{ $oc->scheduled_at->format('D, M d Y') }}</p>
                    <p class="mt-1"><i class="fa-regular fa-clock mr-1"></i>{{ $oc->scheduled_at->format('h:i A') }} · {{ $oc->duration_minutes }} min</p>
                </div>
                <a href="{{ $oc->join_url }}" target="_blank" class="btn-primary w-full justify-center text-sm py-2">
                    <i class="fa-solid fa-video"></i> Join Class
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- PAST --}}
    @if($past->count())
    <div>
        <h2 class="text-lg font-bold text-navy-900 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-clock-rotate-left text-slate-400"></i> Past Classes
        </h2>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-slate-500 uppercase">Title</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-slate-500 uppercase hidden sm:table-cell">Class</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-slate-500 uppercase hidden md:table-cell">Date</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-slate-500 uppercase">Platform</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($past as $oc)
                    <tr class="border-b border-slate-50 hover:bg-slate-50">
                        <td class="px-5 py-3 font-medium text-navy-900">{{ $oc->title }}</td>
                        <td class="px-5 py-3 text-slate-500 hidden sm:table-cell">{{ $oc->gradeClass?->full_name ?? '—' }}</td>
                        <td class="px-5 py-3 text-slate-400 hidden md:table-cell">{{ $oc->scheduled_at->format('M d, Y') }}</td>
                        <td class="px-5 py-3 text-slate-400 capitalize">{{ str_replace('_',' ',$oc->platform) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    @if($live->isEmpty() && $upcoming->isEmpty() && $past->isEmpty())
    <div class="text-center py-20 bg-white rounded-2xl border border-slate-100">
        <i class="fa-solid fa-video-slash text-5xl text-slate-200 mb-4"></i>
        <p class="text-slate-400">No online classes scheduled yet.</p>
    </div>
    @endif
</div>
@endsection