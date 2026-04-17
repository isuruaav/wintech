@extends('layouts.app')
@section('title', 'Grade Classes')

@section('content')
<div class="bg-gradient-to-r from-navy-900 to-navy-700 py-14 text-white text-center">
    <h1 class="text-4xl font-extrabold mb-3">Grade Classes</h1>
    <p class="text-white/60">Grades 6–11, O/L and A/L — English, ICT, Mathematics &amp; Science</p>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Wrap tabs + panels together inside data-tab-group --}}
    <div data-tab-group="subjects">

        {{-- Subject Tabs --}}
        <div class="flex flex-wrap gap-2 mb-8">
            @foreach($subjects as $subject)
            <button data-tab="{{ $subject }}"
                    class="tab-btn px-5 py-2 rounded-full border font-semibold text-sm transition-all
                           {{ $loop->first ? 'bg-navy-900 text-white border-navy-900' : 'bg-white text-slate-600 border-slate-200 hover:border-navy-500' }}">
                {{ $subject }}
            </button>
            @endforeach
        </div>

        {{-- Tab Panels --}}
        @foreach($grouped as $subject => $classes)
        <div data-tab-panel="{{ $subject }}" class="{{ !$loop->first ? 'hidden' : '' }}">
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                @foreach($classes as $class)
                <a href="{{ route('grade.show', $class->slug) }}"
                   class="card-hover bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
                    <div class="flex items-center justify-between mb-3">
                        <span class="bg-navy-100 text-navy-700 text-xs font-bold px-2.5 py-1 rounded-full">{{ $class->grade }}</span>
                        @if($class->medium === 'english')
                            <span class="text-xs font-medium text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">English</span>
                        @elseif($class->medium === 'sinhala')
                            <span class="text-xs font-medium text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full">Sinhala</span>
                        @else
                            <span class="text-xs font-medium text-sky-600 bg-sky-50 px-2 py-0.5 rounded-full">Eng / Sin</span>
                        @endif
                    </div>
                    <h3 class="font-bold text-navy-900 text-base mb-1">{{ $class->subject }}</h3>
          @if($class->teacher_name)
<p class="text-slate-500 text-xs mb-1"><i class="fa-solid fa-chalkboard-user text-navy-300 mr-1"></i>{{ $class->teacher_name }}</p>
@endif
                    <p class="text-slate-400 text-sm mb-3">{{ $class->grade }}</p>
                    @if($class->monthly_fee)
                    <p class="text-navy-700 font-semibold text-sm">Rs. {{ number_format($class->monthly_fee) }}<span class="text-slate-400 font-normal">/month</span></p>
                    @endif
                    @if($class->schedules->count())
                    <div class="mt-3 pt-3 border-t border-slate-100 space-y-1">
                        @foreach($class->schedules->take(2) as $s)
                        <p class="text-xs text-slate-500">
                            <i class="fa-regular fa-calendar text-navy-300 mr-1"></i>
                            {{ $s->day }} {{ \Carbon\Carbon::parse($s->start_time)->format('h:i A') }}
                        </p>
                        @endforeach
                    </div>
                    @endif
                </a>
                @endforeach
            </div>
        </div>
        @endforeach

    </div>
</div>
@endsection