@extends('layouts.admin')
@section('title','Past Papers')
@section('page_title','Past Papers')
@section('breadcrumb','Manage past papers')

@section('content')
<div class="flex items-center justify-between mb-5">
    <p class="text-slate-500 text-sm">{{ $papers->total() }} papers</p>
    <a href="{{ route('admin.papers.create') }}" class="btn-primary text-sm">
        <i class="fa-solid fa-plus"></i> Upload Paper
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="admin-table w-full">
            <thead><tr>
                <th class="text-left">Title</th>
                <th class="text-left hidden sm:table-cell">Subject</th>
                <th class="text-left hidden md:table-cell">Grade</th>
                <th class="text-left hidden lg:table-cell">Year</th>
                <th class="text-center">Status</th>
                <th class="text-center">Actions</th>
            </tr></thead>
            <tbody>
                @forelse($papers as $paper)
                <tr>
                    <td class="font-semibold text-navy-900 text-sm">{{ $paper->title }}</td>
                    <td class="hidden sm:table-cell text-sm text-slate-500">{{ $paper->subject ?? '—' }}</td>
                    <td class="hidden md:table-cell text-sm text-slate-500">{{ $paper->grade ?? '—' }}</td>
                    <td class="hidden lg:table-cell text-sm text-slate-400">{{ $paper->year ?? '—' }}</td>
                    <td class="text-center">
                        <span class="badge {{ $paper->is_active ? 'badge-active' : 'badge-inactive' }}">
                            {{ $paper->is_active ? 'Active' : 'Hidden' }}
                        </span>
                    </td>
                    <td>
                        <div class="flex items-center justify-center gap-1.5">
                            <a href="{{ $paper->file_url }}" target="_blank" class="w-8 h-8 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center" title="View PDF">
                                <i class="fa-solid fa-eye text-xs"></i>
                            </a>
                            <a href="{{ route('admin.papers.edit', $paper) }}" class="w-8 h-8 bg-navy-50 hover:bg-navy-100 text-navy-600 rounded-lg flex items-center justify-center">
                                <i class="fa-solid fa-pen text-xs"></i>
                            </a>
                            <form action="{{ route('admin.papers.destroy', $paper) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button data-confirm="Delete this paper?" class="w-8 h-8 bg-red-50 hover:bg-red-100 text-red-500 rounded-lg flex items-center justify-center">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-12 text-slate-400">No papers yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($papers->hasPages())<div class="px-5 py-4 border-t border-slate-100">{{ $papers->links() }}</div>@endif
</div>
@endsection