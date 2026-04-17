@extends('layouts.app')
@section('title', 'Online Classes')

@section('content')
<div class="bg-gradient-to-r from-navy-900 to-navy-700 py-14 text-white text-center">
    <h1 class="text-4xl font-extrabold mb-3">Online Classes</h1>
    <p class="text-white/60">Join live sessions from the comfort of your home</p>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Live Now Banner --}}
    @if($liveNow->count())
    <div class="bg-green-50 border border-green-200 rounded-2xl p-5 mb-8">
        <div class="flex items-center gap-2 mb-3">
            <span class="inline-flex items-center gap-1.5 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full">
                <span class="w-1.5 h-1.5 rounded-full bg-white animate-ping"></span> LIVE NOW
            </span>
            <span class="text-green-700 font-semibold text-sm">{{ $liveNow->count() }} class(es) happening right now!</span>
        </div>
        <div class="grid sm:grid-cols-2 gap-3">
            @foreach($liveNow as $liveClass)
            <div class="flex items-center justify-between bg-white rounded-xl p-4 border border-green-100">
                <div>
                    <h3 class="font-semibold text-navy-900 text-sm">{{ $liveClass->title }}</h3>
                    <p class="text-slate-400 text-xs">{{ $liveClass->gradeClass?->full_name }}</p>
                </div>
                <a href="{{ $liveClass->join_url }}" target="_blank" class="btn-gold text-xs px-4 py-2">
                    Join <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Filters --}}
    <form method="GET" class="flex flex-wrap gap-3 mb-8 bg-white rounded-2xl p-4 shadow-sm border border-slate-100">
        <select name="grade_class" class="form-input w-auto flex-1 sm:flex-none sm:w-56 text-sm">
            <option value="">All Classes</option>
            @foreach($gradeClasses as $gc)
            <option value="{{ $gc->id }}" {{ request('grade_class') == $gc->id ? 'selected' : '' }}>{{ $gc->full_name }}</option>
            @endforeach
        </select>
        <select name="status" class="form-input w-auto flex-1 sm:flex-none sm:w-36 text-sm">
            <option value="">All Status</option>
            <option value="upcoming" {{ request('status') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
            <option value="live"     {{ request('status') == 'live'     ? 'selected' : '' }}>Live</option>
        </select>
        <button type="submit" class="btn-primary text-sm py-2 px-5">
            <i class="fa-solid fa-filter"></i> Filter
        </button>
    </form>

    {{-- Cards --}}
    @if($classes->isEmpty())
    <div class="text-center py-20 bg-white rounded-2xl border border-slate-100">
        <i class="fa-solid fa-video text-5xl text-slate-200 mb-4"></i>
        <p class="text-slate-400">No upcoming online classes scheduled.</p>
    </div>
    @else
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-8">
        @foreach($classes as $oc)
        <div class="card-hover bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-5">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-10 h-10 bg-navy-900 rounded-xl flex items-center justify-center">
                        <i class="fa-solid fa-video text-white"></i>
                    </div>
                    <span class="badge {{ $oc->status === 'live' ? 'badge-active' : 'badge-pending' }}">
                        {{ ucfirst($oc->status) }}
                    </span>
                </div>
                <h3 class="font-bold text-navy-900 mb-1">{{ $oc->title }}</h3>
                @if($oc->gradeClass)
                <p class="text-slate-400 text-xs mb-3">{{ $oc->gradeClass->full_name }}</p>
                @endif
                <div class="grid grid-cols-2 gap-2 text-xs text-slate-500 mb-4">
                    <span><i class="fa-regular fa-calendar text-navy-300 mr-1"></i>{{ $oc->scheduled_at->format('M d, Y') }}</span>
                    <span><i class="fa-regular fa-clock text-navy-300 mr-1"></i>{{ $oc->scheduled_at->format('h:i A') }}</span>
                </div>
                <a href="{{ $oc->join_url }}" target="_blank"
                   class="flex items-center justify-center gap-2 py-2.5 rounded-xl font-semibold text-sm w-full transition-all
                          {{ $oc->status === 'live' ? 'bg-green-500 hover:bg-green-600 text-white' : 'bg-navy-900 hover:bg-navy-700 text-white' }}">
                    <i class="fa-solid fa-video"></i>
                    {{ $oc->status === 'live' ? 'Join Now — LIVE' : 'Join Class' }}
                </a>
            </div>
        </div>
        @endforeach
    </div>
    {{ $classes->links() }}
    @endif

</div>
@endsection