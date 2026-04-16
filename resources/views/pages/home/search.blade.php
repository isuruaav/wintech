@extends('layouts.app')
@section('title', 'Search: ' . $query)

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="text-2xl font-bold text-navy-900 mb-2">Search Results</h1>
    <p class="text-slate-400 mb-6">{{ $results->count() }} results for "<span class="text-navy-700 font-semibold">{{ $query }}</span>"</p>

    <form action="{{ route('search') }}" method="GET" class="mb-8">
        <div class="flex gap-3">
            <input type="text" name="q" value="{{ $query }}" class="form-input flex-1" placeholder="Search courses, classes...">
            <button type="submit" class="btn-primary px-6">Search</button>
        </div>
    </form>

    @if($results->isEmpty())
    <div class="text-center py-16 bg-white rounded-2xl border border-slate-100">
        <i class="fa-solid fa-magnifying-glass text-4xl text-slate-200 mb-4"></i>
        <p class="text-slate-400">No results found. Try different keywords.</p>
    </div>
    @else
    <div class="space-y-3">
        @foreach($results as $item)
        <a href="{{ $item['url'] }}" class="card-hover flex items-center gap-4 bg-white rounded-xl p-4 border border-slate-100 shadow-sm">
            <div class="w-10 h-10 bg-navy-100 rounded-xl flex items-center justify-center shrink-0">
                <i class="{{ $item['icon'] }} text-navy-600"></i>
            </div>
            <div>
                <span class="text-xs text-navy-500 font-semibold uppercase">{{ $item['type'] }}</span>
                <h3 class="font-semibold text-navy-900 text-sm">{{ $item['title'] }}</h3>
            </div>
            <i class="fa-solid fa-arrow-right text-slate-300 ml-auto"></i>
        </a>
        @endforeach
    </div>
    @endif
</div>
@endsection