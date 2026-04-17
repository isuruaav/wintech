@extends('layouts.app')
@section('title', 'Online Classes')

@section('content')

{{-- Hero --}}
<section class="relative bg-gradient-to-br from-navy-950 to-navy-800 pt-28 pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-flex items-center gap-2 bg-red-500/20 text-red-400 text-xs font-bold px-4 py-2 rounded-full border border-red-500/30 mb-6">
            <span class="w-2 h-2 bg-red-400 rounded-full animate-pulse"></span>
            Live & Upcoming Sessions
        </span>
        <h1 class="text-4xl sm:text-5xl font-extrabold text-white mb-4">Online <span class="text-gold-400">Classes</span></h1>
        <p class="text-white/50 max-w-xl mx-auto">Join live sessions on Google Meet or Zoom from anywhere.</p>
    </div>
</section>

{{-- Live Now --}}
@if($liveNow->count())
<section class="bg-red-50 border-b border-red-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-2 mb-5">
            <span class="w-3 h-3 bg-red-500 rounded-full animate-pulse"></span>
            <h2 class="font-bold text-red-700 text-lg">Happening Right Now</h2>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($liveNow as $liveClass)
            <div class="bg-white rounded-2xl border-2 border-red-300 shadow-sm p-5">
                <div class="flex items-center justify-between mb-3">
                    <span class="inline-flex items-center gap-1.5 bg-red-100 text-red-700 text-xs font-bold px-3 py-1 rounded-full">
                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full animate-pulse"></span> LIVE
                    </span>
                    <span class="text-xs text-slate-400">{{ $liveClass->duration_minutes ?? 60 }} min</span>
                </div>
                <h3 class="font-bold text-navy-900 mb-1">{{ $liveClass->title }}</h3>
                @if($liveClass->gradeClass)
                <p class="text-slate-400 text-xs mb-3">{{ $liveClass->gradeClass->subject }} — Grade {{ $liveClass->gradeClass->grade }}</p>
                @endif
                <a href="{{ $liveClass->join_url }}" target="_blank"
                   class="btn-primary w-full justify-center text-sm py-2.5">
                    <i class="fa-solid fa-video"></i> Join Now
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Filter + Classes --}}
<section class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Filter Bar --}}
        <form method="GET" class="bg-white rounded-2xl border border-slate-200 p-4 mb-8 flex flex-wrap gap-3 items-center shadow-sm">
            <select name="grade_class" class="form-input text-sm py-2 rounded-xl border-slate-200 flex-1 min-w-[180px]">
                <option value="">All Grade Classes</option>
                @foreach($gradeClasses as $gc)
                <option value="{{ $gc->id }}" {{ request('grade_class') == $gc->id ? 'selected' : '' }}>
                    {{ $gc->subject }} — Grade {{ $gc->grade }}
                </option>
                @endforeach
            </select>
            <select name="status" class="form-input text-sm py-2 rounded-xl border-slate-200 w-36">
                <option value="">All Status</option>
                <option value="upcoming" {{ request('status')=='upcoming'?'selected':'' }}>Upcoming</option>
                <option value="live"     {{ request('status')=='live'?'selected':'' }}>Live</option>
            </select>
            <button type="submit" class="btn-primary text-sm py-2 px-5">
                <i class="fa-solid fa-filter"></i> Filter
            </button>
            @if(request()->hasAny(['grade_class','status']))
            <a href="{{ route('online-classes.index') }}" class="text-sm text-slate-400 hover:text-navy-700">Clear</a>
            @endif
        </form>

        {{-- Classes Grid --}}
        @if($classes->count())
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            @foreach($classes as $oc)
            <div class="group bg-white rounded-2xl border border-slate-100 shadow-sm p-5 hover:border-navy-300 hover:shadow-md transition-all">
                {{-- Platform Badge --}}
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 bg-navy-100 group-hover:bg-navy-900 rounded-xl flex items-center justify-center transition-colors">
                        <i class="fa-solid fa-video text-navy-600 group-hover:text-gold-400 transition-colors text-sm"></i>
                    </div>
                    @php
                    $platformNames = ['zoom'=>'Zoom','google_meet'=>'Google Meet','teams'=>'MS Teams','other'=>'Online'];
                    $platformColors = ['zoom'=>'bg-blue-100 text-blue-700','google_meet'=>'bg-green-100 text-green-700','teams'=>'bg-indigo-100 text-indigo-700','other'=>'bg-slate-100 text-slate-600'];
                    @endphp
                    <span class="text-xs font-bold px-3 py-1 rounded-full {{ $platformColors[$oc->platform] ?? 'bg-slate-100 text-slate-600' }}">
                        {{ $platformNames[$oc->platform] ?? $oc->platform }}
                    </span>
                </div>

                <h3 class="font-bold text-navy-900 mb-1 leading-tight">{{ $oc->title }}</h3>

                @if($oc->gradeClass)
                <p class="text-xs text-slate-400 mb-3">{{ $oc->gradeClass->subject }} — Grade {{ $oc->gradeClass->grade }}</p>
                @endif

                <div class="bg-slate-50 rounded-xl px-3 py-2.5 mb-4 text-xs text-slate-600 space-y-1">
                    <p class="flex items-center gap-2">
                        <i class="fa-regular fa-calendar text-navy-400 w-3"></i>
                        {{ $oc->scheduled_at->format('M d, Y') }}
                    </p>
                    <p class="flex items-center gap-2">
                        <i class="fa-regular fa-clock text-navy-400 w-3"></i>
                        {{ $oc->scheduled_at->format('h:i A') }}
                        @if($oc->duration_minutes)
                         · {{ $oc->duration_minutes }} min
                        @endif
                    </p>
                </div>

                {{-- Status --}}
                @if($oc->status === 'live')
                <div class="mb-3">
                    <span class="inline-flex items-center gap-1.5 bg-red-100 text-red-700 text-xs font-bold px-3 py-1 rounded-full">
                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full animate-pulse"></span> LIVE NOW
                    </span>
                </div>
                @endif

                <a href="{{ $oc->join_url }}" target="_blank"
                   class="btn-primary w-full justify-center text-xs py-2.5">
                    <i class="fa-solid fa-video text-xs"></i>
                    {{ $oc->status === 'live' ? 'Join Now' : 'Join Class' }}
                </a>
            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($classes->hasPages())
        <div class="mt-10 flex justify-center">
            {{ $classes->links() }}
        </div>
        @endif

        @else
        <div class="text-center py-20">
            <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-video text-3xl text-slate-300"></i>
            </div>
            <h3 class="font-bold text-navy-900 text-lg mb-2">No Classes Scheduled</h3>
            <p class="text-slate-400 text-sm">Check back soon for upcoming online sessions.</p>
        </div>
        @endif

    </div>
</section>

@endsection