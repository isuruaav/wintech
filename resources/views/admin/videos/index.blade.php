@extends('layouts.admin')
@section('title','Videos')
@section('page_title','Videos')
@section('breadcrumb','Manage video library')

@section('content')
<div class="flex items-center justify-between mb-5">
    <p class="text-slate-500 text-sm">{{ $videos->total() }} videos</p>
    <a href="{{ route('admin.videos.create') }}" class="btn-primary text-sm">
        <i class="fa-solid fa-plus"></i> Add Video
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="admin-table w-full">
            <thead><tr>
                <th class="text-left">Title</th>
                <th class="text-left hidden sm:table-cell">Source</th>
                <th class="text-left hidden md:table-cell">Category</th>
                <th class="text-center">Status</th>
                <th class="text-center">Actions</th>
            </tr></thead>
            <tbody>
                @forelse($videos as $video)
                <tr>
                    <td>
                        <p class="font-semibold text-navy-900 text-sm">{{ $video->title }}</p>
                        <p class="text-xs text-slate-400 truncate max-w-xs">{{ $video->video_url }}</p>
                    </td>
                    <td class="hidden sm:table-cell">
                        <span class="badge badge-pending capitalize">{{ $video->source }}</span>
                    </td>
                    <td class="hidden md:table-cell text-sm text-slate-500">{{ $video->category ?? '—' }}</td>
                    <td class="text-center">
                        <span class="badge {{ $video->is_active ? 'badge-active' : 'badge-inactive' }}">
                            {{ $video->is_active ? 'Active' : 'Hidden' }}
                        </span>
                    </td>
                    <td>
                        <div class="flex items-center justify-center gap-1.5">
                            <a href="{{ route('admin.videos.edit', $video) }}" class="w-8 h-8 bg-navy-50 hover:bg-navy-100 text-navy-600 rounded-lg flex items-center justify-center">
                                <i class="fa-solid fa-pen text-xs"></i>
                            </a>
                            <form action="{{ route('admin.videos.destroy', $video) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button data-confirm="Delete this video?" class="w-8 h-8 bg-red-50 hover:bg-red-100 text-red-500 rounded-lg flex items-center justify-center">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center py-12 text-slate-400">No videos yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($videos->hasPages())<div class="px-5 py-4 border-t border-slate-100">{{ $videos->links() }}</div>@endif
</div>
@endsection