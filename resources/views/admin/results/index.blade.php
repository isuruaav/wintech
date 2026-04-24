@extends('layouts.admin')
@section('title', 'Enter Results')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.exams.index') }}" class="text-slate-400 hover:text-navy-700">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-navy-900">{{ $exam->name }}</h1>
            <p class="text-slate-500 text-sm">{{ $exam->subject }} · Grade {{ $exam->grade }} · {{ $exam->total_marks }} marks · Pass: {{ $exam->pass_marks }}</p>
        </div>
        <div class="ml-auto">
            <form method="POST" action="{{ route('admin.exams.toggle-publish', $exam) }}">
                @csrf @method('PATCH')
                <button type="submit"
                    class="flex items-center gap-2 text-sm font-semibold px-4 py-2 rounded-xl border transition-all
                    {{ $exam->is_published ? 'bg-emerald-50 text-emerald-700 border-emerald-200 hover:bg-emerald-100' : 'bg-slate-50 text-slate-600 border-slate-200 hover:bg-slate-100' }}">
                    <i class="fa-solid {{ $exam->is_published ? 'fa-eye' : 'fa-eye-slash' }}"></i>
                    {{ $exam->is_published ? 'Published' : 'Unpublished' }}
                </button>
            </form>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">

        {{-- Add Single Result --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
            <h2 class="font-bold text-navy-900 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-user-plus text-navy-400"></i> Add / Update Result
            </h2>
            <form method="POST" action="{{ route('admin.exams.results.store', $exam) }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Student</label>
                    <select name="user_id" class="form-input w-full rounded-xl border-slate-200 text-sm">
                        <option value="">— Select Student —</option>
                        @foreach($students as $student)
                        <option value="{{ $student->id }}">{{ $student->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Marks (out of {{ $exam->total_marks }})</label>
                    <input type="number" name="marks" step="0.5" min="0" max="{{ $exam->total_marks }}"
                           class="form-input w-full rounded-xl border-slate-200 text-sm"
                           placeholder="0">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Remarks (Optional)</label>
                    <input type="text" name="remarks"
                           class="form-input w-full rounded-xl border-slate-200 text-sm"
                           placeholder="Good performance...">
                </div>
                @if(session('success'))
                <p class="text-emerald-600 text-xs font-semibold">✓ {{ session('success') }}</p>
                @endif
                <button type="submit" class="btn-primary w-full justify-center text-sm">
                    <i class="fa-solid fa-save"></i> Save Result
                </button>
            </form>
        </div>

        {{-- Results Table --}}
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                <h2 class="font-bold text-navy-900">Results ({{ $results->count() }})</h2>
                @if($results->count())
                @php
                $avg = $results->avg('marks');
                $passCount = $results->where('status','pass')->count();
                @endphp
                <div class="flex gap-4 text-xs text-slate-500">
                    <span>Avg: <strong class="text-navy-900">{{ number_format($avg,1) }}</strong></span>
                    <span>Pass: <strong class="text-emerald-600">{{ $passCount }}</strong>/{{ $results->count() }}</span>
                </div>
                @endif
            </div>
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="text-left px-5 py-3 font-semibold text-slate-600">Student</th>
                        <th class="text-center px-4 py-3 font-semibold text-slate-600">Marks</th>
                        <th class="text-center px-4 py-3 font-semibold text-slate-600">Grade</th>
                        <th class="text-center px-4 py-3 font-semibold text-slate-600">Status</th>
                        <th class="text-right px-4 py-3 font-semibold text-slate-600">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($results as $result)
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-3">
                            <p class="font-semibold text-navy-900">{{ $result->user->name }}</p>
                            <p class="text-xs text-slate-400">{{ $result->user->email }}</p>
                        </td>
                        <td class="px-4 py-3 text-center font-bold text-navy-900">
                            {{ $result->marks }} / {{ $exam->total_marks }}
                            <p class="text-xs text-slate-400 font-normal">
                                {{ number_format(($result->marks / $exam->total_marks) * 100, 1) }}%
                            </p>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="inline-block w-8 h-8 rounded-full text-sm font-extrabold flex items-center justify-center {{ $result->grade_color }}">
                                {{ $result->grade_letter ?? '—' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $result->status === 'pass' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-600' }}">
                                {{ ucfirst($result->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <form method="POST" action="{{ route('admin.exams.results.destroy', [$exam, $result]) }}"
                                  onsubmit="return confirm('Delete this result?')">
                                @csrf @method('DELETE')
                                <button class="text-xs px-2 py-1 bg-red-50 text-red-600 rounded-lg hover:bg-red-100">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-8 text-center text-slate-400 text-sm">
                            No results yet. Add results using the form.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection