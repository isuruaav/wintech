@extends('layouts.app')
@section('title', 'My Results')

@section('content')

{{-- Hero --}}
<section class="relative bg-gradient-to-br from-navy-950 to-navy-800 pt-28 pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <span class="inline-block bg-gold-500/20 text-gold-400 text-xs font-bold px-4 py-2 rounded-full border border-gold-500/20 mb-4">
                    <i class="fa-solid fa-graduation-cap mr-1"></i> Results Portal
                </span>
                <h1 class="text-3xl sm:text-4xl font-extrabold text-white mb-2">My <span class="text-gold-400">Results</span></h1>
                <p class="text-white/50">Welcome, {{ Auth::user()->name }}</p>
            </div>

            {{-- Quick Stats --}}
            <div class="flex flex-wrap gap-4">
                @foreach([
                    [$totalExams,  'Exams',       'fa-file-alt',      'bg-blue-500/20',   'text-blue-400'],
                    [$passCount,   'Passed',       'fa-check-circle',  'bg-emerald-500/20','text-emerald-400'],
                    [$avgMarks.'%','Avg Marks',    'fa-chart-bar',     'bg-gold-500/20',   'text-gold-400'],
                    [$bestGrade,   'Best Grade',   'fa-trophy',        'bg-purple-500/20', 'text-purple-400'],
                ] as [$val, $label, $icon, $bg, $color])
                <div class="bg-white/10 backdrop-blur rounded-2xl px-4 py-3 text-center min-w-[80px] border border-white/10">
                    <div class="w-8 h-8 {{ $bg }} rounded-lg flex items-center justify-center mx-auto mb-1">
                        <i class="fa-solid {{ $icon }} {{ $color }} text-xs"></i>
                    </div>
                    <p class="text-white font-extrabold text-lg leading-none">{{ $val }}</p>
                    <p class="text-white/40 text-xs mt-0.5">{{ $label }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- Results --}}
<section class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Filter --}}
        <form method="GET" class="bg-white rounded-2xl border border-slate-200 p-4 mb-8 flex flex-wrap gap-3 items-center shadow-sm">
            <select name="subject" class="form-input text-sm py-2 rounded-xl border-slate-200 flex-1 min-w-[160px]">
                <option value="">All Subjects</option>
                @foreach($subjects as $s)
                <option value="{{ $s }}" {{ request('subject')==$s?'selected':'' }}>{{ $s }}</option>
                @endforeach
            </select>
            <select name="grade" class="form-input text-sm py-2 rounded-xl border-slate-200 w-36">
                <option value="">All Grades</option>
                @foreach($grades as $g)
                <option value="{{ $g }}" {{ request('grade')==$g?'selected':'' }}>Grade {{ $g }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn-primary text-sm py-2 px-5">
                <i class="fa-solid fa-filter"></i> Filter
            </button>
            @if(request()->hasAny(['subject','grade']))
            <a href="{{ route('results.index') }}" class="text-sm text-slate-400 hover:text-navy-700">Clear</a>
            @endif
        </form>

        {{-- Results List --}}
        @if($results->count())
        <div class="space-y-4">
            @foreach($results as $result)
            @php
            $exam       = $result->exam;
            $percentage = $exam->total_marks > 0 ? round(($result->marks / $exam->total_marks) * 100, 1) : 0;
            $barColor   = $result->status === 'pass'
                ? ($percentage >= 75 ? 'bg-emerald-500' : 'bg-blue-500')
                : 'bg-red-400';
            $typeColors = ['term_test'=>'bg-blue-100 text-blue-700','mid_year'=>'bg-purple-100 text-purple-700','final'=>'bg-red-100 text-red-700','mock'=>'bg-amber-100 text-amber-700','other'=>'bg-slate-100 text-slate-600'];
            @endphp
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                <div class="p-5">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-4">

                        {{-- Grade Circle --}}
                        <div class="shrink-0 w-16 h-16 rounded-2xl flex flex-col items-center justify-center font-extrabold text-2xl border-2
                            {{ $result->status === 'pass' ? 'bg-emerald-50 border-emerald-200 text-emerald-700' : 'bg-red-50 border-red-200 text-red-600' }}">
                            {{ $result->grade_letter ?? '—' }}
                        </div>

                        {{-- Exam Info --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2 mb-1">
                                <h3 class="font-bold text-navy-900 text-base">{{ $exam->title }}</h3>
                                <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $typeColors[$exam->type] ?? 'bg-slate-100 text-slate-600' }}">
                                    {{ $exam->type_name }}
                                </span>
                                <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $result->status === 'pass' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-600' }}">
                                    {{ ucfirst($result->status) }}
                                </span>
                            </div>
                            <p class="text-slate-500 text-sm">
                                {{ $exam->subject }} · Grade {{ $exam->grade }}
                                @if($exam->exam_date)
                                · <span class="text-slate-400">{{ $exam->exam_date->format('M d, Y') }}</span>
                                @endif
                            </p>
                            @if($result->remarks)
                            <p class="text-slate-400 text-xs mt-1 italic">{{ $result->remarks }}</p>
                            @endif
                        </div>

                        {{-- Marks --}}
                        <div class="shrink-0 text-right">
                            <p class="text-2xl font-extrabold text-navy-900">{{ $result->marks }}</p>
                            <p class="text-slate-400 text-xs">out of {{ $exam->total_marks }}</p>
                            <p class="text-sm font-bold {{ $result->status === 'pass' ? 'text-emerald-600' : 'text-red-500' }} mt-0.5">
                                {{ $percentage }}%
                            </p>
                        </div>
                    </div>

                    {{-- Progress Bar --}}
                    <div class="mt-4 bg-slate-100 rounded-full h-2 overflow-hidden">
                        <div class="{{ $barColor }} h-2 rounded-full transition-all duration-700"
                             style="width: {{ $percentage }}%"></div>
                    </div>
                    <div class="flex justify-between text-xs text-slate-400 mt-1">
                        <span>0</span>
                        <span class="text-slate-500">Pass: {{ $exam->pass_marks }}</span>
                        <span>{{ $exam->total_marks }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @else
        <div class="text-center py-20">
            <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-file-circle-question text-3xl text-slate-300"></i>
            </div>
            <h3 class="font-bold text-navy-900 text-lg mb-2">No Results Yet</h3>
            <p class="text-slate-400 text-sm max-w-sm mx-auto">
                @if(request()->hasAny(['subject','grade']))
                    No results found for the selected filter.
                @else
                    Your exam results will appear here once published by the admin.
                @endif
            </p>
            @if(request()->hasAny(['subject','grade']))
            <a href="{{ route('results.index') }}" class="btn-primary mt-4 inline-flex">Clear Filter</a>
            @endif
        </div>
        @endif
    </div>
</section>

@endsection