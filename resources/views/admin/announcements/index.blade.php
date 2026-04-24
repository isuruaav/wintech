@extends('layouts.admin')

@section('title', 'Announcements')
@section('page_title', 'Announcements')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-bold text-slate-800">All Announcements</h2>
        <p class="text-slate-400 text-sm">{{ $announcements->total() }} total</p>
    </div>
    <a href="{{ route('admin.announcements.create') }}"
       class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-xl flex items-center gap-2">
        <i class="fa-solid fa-plus"></i> New Announcement
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    @forelse($announcements as $a)
    <div class="flex items-start gap-4 p-4 border-b border-slate-50 last:border-0 hover:bg-slate-50 transition-colors">
        {{-- Type badge --}}
        <span class="shrink-0 mt-0.5 text-xs font-bold px-2 py-1 rounded-lg
            {{ $a->type === 'urgent' ? 'bg-red-100 text-red-600' :
               ($a->type === 'exam' ? 'bg-blue-100 text-blue-600' :
               ($a->type === 'event' ? 'bg-purple-100 text-purple-600' :
               ($a->type === 'holiday' ? 'bg-green-100 text-green-600' :
               'bg-yellow-100 text-yellow-600'))) }}">
            {{ ucfirst($a->type ?? 'general') }}
        </span>

        {{-- Content --}}
        <div class="flex-1 min-w-0">
            <p class="font-semibold text-slate-800 truncate">{{ $a->title }}</p>
            <p class="text-slate-400 text-sm truncate">{{ Str::limit($a->content, 80) }}</p>
            <p class="text-slate-300 text-xs mt-1">{{ $a->created_at->diffForHumans() }}</p>
        </div>

        {{-- Status + Actions --}}
        <div class="flex items-center gap-2 shrink-0">
            <form action="{{ route('admin.announcements.toggle', $a) }}" method="POST">
                @csrf @method('PATCH')
                <button class="text-xs px-2 py-1 rounded-lg {{ $a->is_active ? 'bg-green-100 text-green-600' : 'bg-slate-100 text-slate-400' }}">
                    {{ $a->is_active ? 'Active' : 'Inactive' }}
                </button>
            </form>
            <a href="{{ route('admin.announcements.edit', $a) }}"
               class="text-slate-400 hover:text-blue-600 p-1.5 rounded-lg hover:bg-blue-50 transition-colors">
                <i class="fa-solid fa-pen text-xs"></i>
            </a>
            <form action="{{ route('admin.announcements.destroy', $a) }}" method="POST"
                  onsubmit="return confirm('Delete this announcement?')">
                @csrf @method('DELETE')
                <button class="text-slate-400 hover:text-red-600 p-1.5 rounded-lg hover:bg-red-50 transition-colors">
                    <i class="fa-solid fa-trash text-xs"></i>
                </button>
            </form>
        </div>
    </div>
    @empty
    <div class="text-center py-16 text-slate-400">
        <i class="fa-solid fa-bullhorn text-4xl mb-3 opacity-30"></i>
        <p class="font-medium">No announcements yet</p>
        <a href="{{ route('admin.announcements.create') }}" class="text-blue-500 text-sm mt-1 inline-block">Create one</a>
    </div>
    @endforelse
</div>

<div class="mt-4">{{ $announcements->links() }}</div>
@endsection