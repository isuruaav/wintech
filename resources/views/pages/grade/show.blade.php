@extends('layouts.app')
@section('title', $class->full_name)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <nav class="flex items-center gap-2 text-sm text-slate-400 mb-6">
        <a href="{{ route('grade.index') }}" class="hover:text-navy-700">Grade Classes</a>
        <i class="fa-solid fa-chevron-right text-xs"></i>
        <span class="text-navy-700">{{ $class->full_name }}</span>
    </nav>

    <div class="grid lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-navy-800 to-navy-950 px-6 py-8 text-white">
                    <span class="bg-gold-500/20 text-gold-400 text-xs font-bold px-3 py-1 rounded-full border border-gold-500/30 mb-3 inline-block">{{ $class->grade }}</span>
                    <h1 class="text-2xl font-extrabold mb-1">{{ $class->subject }}</h1>
           @if($class->teacher_name)<p class="text-white/70 text-sm mb-1"><i class="fa-solid fa-chalkboard-user mr-1"></i>{{ $class->teacher_name }}</p>@endif
                    @if($class->medium)
                    <span class="inline-block text-xs font-semibold px-2.5 py-1 rounded-full mt-1
                        {{ $class->medium === 'english' ? 'bg-emerald-500/20 text-emerald-300' : ($class->medium === 'sinhala' ? 'bg-amber-500/20 text-amber-300' : 'bg-sky-500/20 text-sky-300') }}">
                        <i class="fa-solid fa-language mr-1"></i>
                        {{ $class->medium === 'english' ? 'English Medium' : ($class->medium === 'sinhala' ? 'Sinhala Medium' : 'English & Sinhala') }}
                    </span>
                    @endif
                </div>
                <div class="p-6">
                    @if($class->description)<p class="text-slate-600 text-sm leading-relaxed mb-4">{{ $class->description }}</p>@endif
                    @if($class->schedules->count())
                    <h3 class="font-bold text-navy-900 mb-3">Class Schedule</h3>
                    <div class="space-y-2">
                        @foreach($class->schedules as $s)
                        <div class="flex items-center gap-3 bg-navy-50 rounded-xl px-4 py-3">
                            <i class="fa-regular fa-calendar text-navy-400"></i>
                            <span class="font-medium text-navy-900 text-sm">{{ $s->day }}</span>
                            <span class="text-slate-400 text-sm">{{ \Carbon\Carbon::parse($s->start_time)->format('h:i A') }} – {{ \Carbon\Carbon::parse($s->end_time)->format('h:i A') }}</span>
                            @if($s->venue)<span class="text-slate-400 text-xs ml-auto"><i class="fa-solid fa-location-dot mr-1"></i>{{ $s->venue }}</span>@endif
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            @if($upcoming->count())
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h3 class="font-bold text-navy-900 mb-4">Upcoming Online Classes</h3>
                <div class="space-y-3">
                    @foreach($upcoming as $oc)
                    <div class="flex items-center justify-between bg-navy-50 rounded-xl p-4">
                        <div>
                            <p class="font-semibold text-navy-900 text-sm">{{ $oc->title }}</p>
                            <p class="text-xs text-slate-400 mt-0.5">{{ $oc->scheduled_at->format('M d, Y · h:i A') }} · {{ $oc->duration_minutes }} min</p>
                        </div>
                        <a href="{{ $oc->join_url }}" target="_blank" class="btn-primary text-xs py-2 px-4">Join</a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <div>
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sticky top-24">
                @if($class->monthly_fee)
                <div class="text-center mb-5 pb-5 border-b border-slate-100">
                    <p class="text-slate-400 text-sm">Monthly Fee</p>
                    <p class="text-3xl font-extrabold text-navy-900 mt-1">Rs. {{ number_format($class->monthly_fee) }}</p>
                </div>
                @endif
                <div class="space-y-3 text-sm mb-5">
                    <div class="flex items-center gap-3 text-slate-600">
                        <i class="fa-solid fa-graduation-cap text-navy-400 w-5"></i>
                        <span class="font-medium">{{ $class->grade }}</span>
                    </div>
                    <div class="flex items-center gap-3 text-slate-600">
                        <i class="fa-solid fa-language text-navy-400 w-5"></i>
                        <span>
                            @if($class->medium === 'english') English Medium
                            @elseif($class->medium === 'sinhala') Sinhala Medium
                            @else English &amp; Sinhala
                            @endif
                        </span>
                    </div>
                    <div class="flex items-center gap-3 text-slate-600">
                        <i class="fa-solid fa-laptop text-navy-400 w-5"></i>
                        <span>{{ $class->mode === 'both' ? 'Physical + Online' : ucfirst($class->mode) }}</span>
                    </div>
                </div>
                <a href="https://wa.me/94784161920?text=I want to join {{ urlencode($class->full_name) }}" target="_blank" class="btn-gold w-full justify-center mb-3">
                    <i class="fa-brands fa-whatsapp"></i> Enrol via WhatsApp
                </a>
                <a href="{{ route('contact') }}" class="btn-primary w-full justify-center text-sm">
                    <i class="fa-solid fa-envelope"></i> Send Enquiry
                </a>
            </div>
        </div>
    </div>
</div>
@endsection