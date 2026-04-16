@extends('layouts.admin')
@section('title','Exams')
@section('page_title','Exams & Results')
@section('breadcrumb','Manage exams and student results')

@section('content')
<div class="flex items-center justify-between mb-5">
    <p class="text-slate-500 text-sm">{{ $exams->total() }} total</p>
    <a href="{{ route('admin.exams.create') }}" class="btn-primary text-sm">
        <i class="fa-solid fa-plus"></i> Create Exam
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="admin-table w-full">
            <thead><tr>
                <th class="text-left">Exam</th>
                <th class="text-left hidden sm:table-cell">Class</th>
                <th class="text-left hidden md:table-cell">Date</th>
                <th class="text-center hidden md:table-cell">Marks</th>
                <th class="text-center">Published</th>
                <th class="text-center">Actions</th>
            </tr></thead>
            <tbody>
                @forelse($exams as $exam)
                <tr>
                    <td>
                        <p class="font-semibold text-navy-900 text-sm">{{ $exam->title }}</p>
                    </td>
                    <td class="hidden sm:table-cell text-sm text-slate-500">{{ $exam->gradeClass->full_name }}</td>
                    <td class="hidden md:table-cell text-sm text-slate-400">{{ $exam->exam_date?->format('M d, Y') ?? '—' }}</td>
                    <td class="hidden md:table-cell text-sm text-slate-500 text-center">{{ $exam->total_marks }}</td>
                    <td class="text-center">
                        <form action="{{ route('admin.exams.toggle-publish', $exam) }}" method="POST" class="inline">
                            @csrf
                            <button class="badge {{ $exam->is_published ? 'badge-active' : 'badge-inactive' }} cursor-pointer hover:opacity-80">
                                {{ $exam->is_published ? 'Published' : 'Draft' }}
                            </button>
                        </form>
                    </td>
                    <td>
                        <div class="flex items-center justify-center gap-1.5">
                            <a href="{{ route('admin.exams.manage', $exam) }}"
                                class="flex items-center gap-1 px-3 h-8 bg-navy-50 hover:bg-navy-100 text-navy-600 rounded-lg text-xs font-semibold">
                                <i class="fa-solid fa-list-check text-xs"></i> Results
                            </a>
                            <form action="{{ route('admin.exams.destroy', $exam) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button data-confirm="Delete exam {{ $exam->title }}?" class="w-8 h-8 bg-red-50 hover:bg-red-100 text-red-500 rounded-lg flex items-center justify-center">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-12 text-slate-400">No exams yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($exams->hasPages())<div class="px-5 py-4 border-t border-slate-100">{{ $exams->links() }}</div>@endif
</div>
@endsection