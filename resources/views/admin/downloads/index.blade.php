@extends('layouts.admin')
@section('title','Downloads')
@section('page_title','Downloads')
@section('breadcrumb','Manage downloadable files')

@section('content')
<div class="flex items-center justify-between mb-5">
    <p class="text-slate-500 text-sm">{{ $downloads->total() }} files</p>
    <a href="{{ route('admin.downloads.create') }}" class="btn-primary text-sm">
        <i class="fa-solid fa-plus"></i> Upload File
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="admin-table w-full">
            <thead><tr>
                <th class="text-left">Title</th>
                <th class="text-left hidden sm:table-cell">Category</th>
                <th class="text-center">Status</th>
                <th class="text-center">Actions</th>
            </tr></thead>
            <tbody>
                @forelse($downloads as $dl)
                <tr>
                    <td>
                        <p class="font-semibold text-navy-900 text-sm">{{ $dl->title }}</p>
                        @if($dl->description)<p class="text-xs text-slate-400">{{ Str::limit($dl->description, 40) }}</p>@endif
                    </td>
                    <td class="hidden sm:table-cell text-sm text-slate-500">{{ $dl->category ?? '—' }}</td>
                    <td class="text-center">
                        <span class="badge {{ $dl->is_active ? 'badge-active' : 'badge-inactive' }}">
                            {{ $dl->is_active ? 'Active' : 'Hidden' }}
                        </span>
                    </td>
                    <td>
                        <div class="flex items-center justify-center gap-1.5">
                            <a href="{{ $dl->file_url }}" target="_blank" class="w-8 h-8 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center">
                                <i class="fa-solid fa-download text-xs"></i>
                            </a>
                            <a href="{{ route('admin.downloads.edit', $dl) }}" class="w-8 h-8 bg-navy-50 hover:bg-navy-100 text-navy-600 rounded-lg flex items-center justify-center">
                                <i class="fa-solid fa-pen text-xs"></i>
                            </a>
                            <form action="{{ route('admin.downloads.destroy', $dl) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button data-confirm="Delete this file?" class="w-8 h-8 bg-red-50 hover:bg-red-100 text-red-500 rounded-lg flex items-center justify-center">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center py-12 text-slate-400">No files yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($downloads->hasPages())<div class="px-5 py-4 border-t border-slate-100">{{ $downloads->links() }}</div>@endif
</div>
@endsection