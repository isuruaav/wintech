@extends('layouts.app')
@section('title', 'Past Papers')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="text-center mb-10">
        <h1 class="section-title mb-3">Past <span>Papers</span></h1>
        <p class="text-slate-500 max-w-xl mx-auto">Download past exam papers for practice and revision.</p>
    </div>

    @if($papers->isEmpty())
    <div class="text-center py-20 bg-white rounded-2xl border border-slate-100">
        <i class="fa-solid fa-file-pdf text-5xl text-slate-200 mb-4"></i>
        <p class="text-slate-400">No papers available yet.</p>
    </div>
    @else
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-slate-500 uppercase">Title</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-slate-500 uppercase hidden sm:table-cell">Subject</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-slate-500 uppercase hidden md:table-cell">Grade</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-slate-500 uppercase hidden md:table-cell">Year</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-slate-500 uppercase">Download</th>
                </tr>
            </thead>
            <tbody>
                @foreach($papers as $paper)
                <tr class="border-b border-slate-50 hover:bg-slate-50 transition-colors">
                    <td class="px-5 py-4 font-medium text-navy-900">{{ $paper->title }}</td>
                    <td class="px-5 py-4 text-slate-500 hidden sm:table-cell">{{ $paper->subject ?? '—' }}</td>
                    <td class="px-5 py-4 text-slate-500 hidden md:table-cell">{{ $paper->grade ?? '—' }}</td>
                    <td class="px-5 py-4 text-slate-400 hidden md:table-cell">{{ $paper->year ?? '—' }}</td>
                    <td class="px-5 py-4 text-center">
                        <a href="{{ $paper->file_url }}" target="_blank"
                            class="inline-flex items-center gap-1.5 bg-navy-100 hover:bg-navy-900 text-navy-700 hover:text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors">
                            <i class="fa-solid fa-download"></i> PDF
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection