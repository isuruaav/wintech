@extends('layouts.admin')
@section('title','Manage Results')
@section('page_title','Manage Results')
@section('breadcrumb','Exams / Results')

@section('content')
<div class="mb-5 flex flex-wrap items-center justify-between gap-3">
    <div>
        <h2 class="font-bold text-navy-900">{{ $exam->title }}</h2>
        <p class="text-sm text-slate-400">{{ $exam->gradeClass->full_name }} · Total Marks: {{ $exam->total_marks }}</p>
    </div>
    <div class="flex gap-3">
        <form action="{{ route('admin.exams.toggle-publish', $exam) }}" method="POST" class="inline">
            @csrf
            <button class="flex items-center gap-2 {{ $exam->is_published ? 'bg-amber-500 hover:bg-amber-600' : 'bg-green-500 hover:bg-green-600' }} text-white font-semibold text-sm px-4 py-2 rounded-xl transition-colors">
                <i class="fa-solid {{ $exam->is_published ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                {{ $exam->is_published ? 'Unpublish' : 'Publish Results' }}
            </button>
        </form>
        <a href="{{ route('admin.exams.index') }}" class="px-4 py-2 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-sm font-medium">
            <i class="fa-solid fa-arrow-left mr-1"></i> Back
        </a>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <form action="{{ route('admin.exams.save-results', $exam) }}" method="POST">
        @csrf
        <div class="overflow-x-auto">
            <table class="admin-table w-full">
                <thead><tr>
                    <th class="text-left">Student</th>
                    <th class="text-left hidden sm:table-cell">Index No</th>
                    <th class="text-center w-40">Marks (/ {{ $exam->total_marks }})</th>
                    <th class="text-center hidden sm:table-cell">Grade</th>
                </tr></thead>
                <tbody>
                    @forelse($students as $student)
                    @php $mark = $results[$student->id] ?? null; @endphp
                    <tr>
                        <td>
                            <div class="flex items-center gap-3">
                                <img src="{{ $student->avatar_url }}" class="w-8 h-8 rounded-lg object-cover" alt="">
                                <p class="font-semibold text-navy-900 text-sm">{{ $student->name }}</p>
                            </div>
                        </td>
                        <td class="hidden sm:table-cell text-sm text-slate-400 font-mono">{{ $student->index_number ?? '—' }}</td>
                        <td class="text-center">
                            <input type="number" name="marks[{{ $student->id }}]"
                                value="{{ $mark }}"
                                min="0" max="{{ $exam->total_marks }}"
                                class="w-24 text-center border border-slate-200 rounded-lg px-2 py-1.5 text-sm focus:outline-none focus:border-navy-400"
                                placeholder="—">
                        </td>
                        <td class="text-center hidden sm:table-cell">
                            @if($mark !== null)
                            @php
                                $pct = ($mark / $exam->total_marks) * 100;
                                $g = $pct >= 75 ? 'A' : ($pct >= 65 ? 'B' : ($pct >= 55 ? 'C' : ($pct >= 35 ? 'S' : 'F')));
                                $c = $g === 'A' ? 'badge-active' : ($g === 'F' ? 'badge-inactive' : 'badge-pending');
                            @endphp
                            <span class="badge {{ $c }}">{{ $g }}</span>
                            @else
                            <span class="text-slate-300 text-sm">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center py-12 text-slate-400">No active students found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($students->count())
        <div class="px-5 py-4 border-t border-slate-100 flex gap-3">
            <button type="submit" class="btn-primary">
                <i class="fa-solid fa-floppy-disk"></i> Save Results
            </button>
        </div>
        @endif
    </form>
</div>
@endsection