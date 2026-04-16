@extends('layouts.app')
@section('title', 'My Results')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Student Card --}}
    <div class="bg-gradient-to-r from-navy-800 to-navy-950 rounded-2xl p-6 mb-8 text-white">
        <div class="flex items-center gap-4">
            <img src="{{ $student->avatar_url }}" class="w-14 h-14 rounded-xl object-cover border-2 border-gold-500" alt="">
            <div>
                <h1 class="text-xl font-extrabold">{{ $student->name }}</h1>
                <p class="text-white/60 text-sm">Index: <span class="text-gold-400 font-bold">{{ $student->index_number ?? 'N/A' }}</span></p>
                <p class="text-white/50 text-xs mt-0.5">{{ $student->email }}</p>
            </div>
        </div>
    </div>

    @if($results->isEmpty())
    <div class="bg-white rounded-2xl border border-slate-100 p-12 text-center shadow-sm">
        <i class="fa-solid fa-file-circle-question text-5xl text-slate-200 mb-4"></i>
        <p class="text-slate-500 font-medium">No published results yet.</p>
        <p class="text-slate-400 text-sm mt-1">Check back after your exams are published.</p>
    </div>
    @else
    <div class="space-y-4">
        @foreach($results as $result)
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden reveal">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                <div>
                    <h3 class="font-bold text-navy-900">{{ $result->exam->title }}</h3>
                    <p class="text-xs text-slate-400 mt-0.5">{{ $result->exam->gradeClass->full_name }} · {{ $result->exam->exam_date?->format('M d, Y') ?? 'N/A' }}</p>
                </div>
                <span class="badge {{ $result->grade_color }} text-sm px-4 py-1.5">{{ $result->letter_grade }}</span>
            </div>
            <div class="px-6 py-4">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-slate-500">Marks Obtained</span>
                    <span class="font-bold text-navy-900">{{ $result->marks_obtained }} / {{ $result->exam->total_marks }}</span>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-2.5">
                    <div class="h-2.5 rounded-full transition-all duration-700
                        {{ $result->percentage >= 75 ? 'bg-green-500' : ($result->percentage >= 55 ? 'bg-blue-500' : ($result->percentage >= 35 ? 'bg-yellow-500' : 'bg-red-500')) }}"
                        style="width: {{ $result->percentage }}%">
                    </div>
                </div>
                <p class="text-right text-xs text-slate-400 mt-1">{{ $result->percentage }}%</p>
                @if($result->remarks)
                <p class="text-xs text-slate-500 mt-2 bg-slate-50 rounded-lg px-3 py-2"><i class="fa-solid fa-comment mr-1"></i>{{ $result->remarks }}</p>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <div class="mt-6 text-center">
        <form action="{{ route('logout') }}" method="POST" class="inline">
            @csrf
            <button class="text-sm text-slate-400 hover:text-red-500 transition-colors">
                <i class="fa-solid fa-right-from-bracket mr-1"></i> Logout
            </button>
        </form>
    </div>
</div>
@endsection