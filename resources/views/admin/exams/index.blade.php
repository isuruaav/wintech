@extends('layouts.admin')
@section('title', 'Exams')

@section('content')
<div class="space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-navy-900">Exams</h1>
            <p class="text-slate-500 text-sm mt-1">Manage exams and publish results</p>
        </div>
        <a href="{{ route('admin.exams.create') }}" class="btn-primary">
            <i class="fa-solid fa-plus"></i> Add Exam
        </a>
    </div>

{{-- Filter --}}
    <form method="GET" class="bg-white rounded-xl border border-slate-200 p-4 flex flex-wrap gap-3 items-center">
        <select name="subject" class="form-input text-sm py-2 rounded-lg border-slate-200 w-40">
            <option value="">All Subjects</option>
            @foreach($subjects ?? [] as $s)
            <option value="{{ $s }}" {{ request('subject')==$s?'selected':'' }}>{{ $s }}</option>
            @endforeach
        </select>
        <select name="grade" class="form-input text-sm py-2 rounded-lg border-slate-200 w-36">
            <option value="">All Grades</option>
            @foreach($grades ?? [] as $g)
            <option value="{{ $g }}" {{ request('grade')==$g?'selected':'' }}>Grade {{ $g }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-primary text-sm py-2 px-4">Filter</button>
        <a href="{{ route('admin.exams.index') }}" class="text-sm text-slate-500 hover:text-navy-700">Clear</a>
    </form>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="text-left px-5 py-3 font-semibold text-slate-600">Exam</th>
                    <th class="text-left px-5 py-3 font-semibold text-slate-600">Subject / Grade</th>
                    <th class="text-left px-5 py-3 font-semibold text-slate-600">Type</th>
                    <th class="text-left px-5 py-3 font-semibold text-slate-600">Date</th>
                    <th class="text-left px-5 py-3 font-semibold text-slate-600">Marks</th>
                    <th class="text-left px-5 py-3 font-semibold text-slate-600">Results</th>
                    <th class="text-left px-5 py-3 font-semibold text-slate-600">Published</th>
                    <th class="text-right px-5 py-3 font-semibold text-slate-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($exams as $exam)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-5 py-3 font-semibold text-navy-900">{{ $exam->title }}</td>
                    <td class="px-5 py-3 text-slate-600">
                        {{ $exam->subject }} <span class="text-slate-400">·</span> Grade {{ $exam->grade }}
                    </td>
                    <td class="px-5 py-3">
                        @php
                        $typeColors = ['term_test'=>'bg-blue-100 text-blue-700','mid_year'=>'bg-purple-100 text-purple-700','final'=>'bg-red-100 text-red-700','mock'=>'bg-amber-100 text-amber-700','other'=>'bg-slate-100 text-slate-600'];
                        @endphp
                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $typeColors[$exam->type] ?? 'bg-slate-100 text-slate-600' }}">
                            {{ $exam->type_name }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-slate-500">
                        {{ $exam->exam_date ? $exam->exam_date->format('M d, Y') : '—' }}
                    </td>
                    <td class="px-5 py-3 text-slate-600">
                        {{ $exam->pass_marks }} / {{ $exam->total_marks }}
                    </td>
                    <td class="px-5 py-3">
                        <a href="{{ route('admin.exams.results', $exam) }}"
                           class="inline-flex items-center gap-1.5 text-xs font-semibold bg-navy-50 text-navy-700 px-3 py-1.5 rounded-lg hover:bg-navy-100 transition-colors">
                            <i class="fa-solid fa-list-check"></i>
                            {{ $exam->results()->count() }} Results
                        </a>
                    </td>
                    <td class="px-5 py-3">
                        <form method="POST" action="{{ route('admin.exams.toggle-publish', $exam) }}">
                            @csrf @method('PATCH')
                            <button type="submit"
                                class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors {{ $exam->is_published ? 'bg-emerald-500' : 'bg-slate-200' }}">
                                <span class="inline-block h-4 w-4 transform rounded-full bg-white shadow transition-transform {{ $exam->is_published ? 'translate-x-6' : 'translate-x-1' }}"></span>
                            </button>
                        </form>
                    </td>
                    <td class="px-5 py-3 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.exams.edit', $exam) }}"
                               class="text-xs px-2 py-1 bg-navy-50 text-navy-700 rounded-lg hover:bg-navy-100">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.exams.destroy', $exam) }}"
                                  onsubmit="return confirm('Delete this exam and all its results?')">
                                @csrf @method('DELETE')
                                <button class="text-xs px-2 py-1 bg-red-50 text-red-600 rounded-lg hover:bg-red-100">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-5 py-10 text-center text-slate-400">
                        <i class="fa-solid fa-file-circle-question text-3xl mb-3 block opacity-30"></i>
                        No exams found. <a href="{{ route('admin.exams.create') }}" class="text-navy-600 font-semibold">Add one</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if($exams->hasPages())
        <div class="px-5 py-4 border-t border-slate-100">{{ $exams->links() }}</div>
        @endif
    </div>
</div>
@endsection