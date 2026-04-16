@extends('layouts.admin')
@section('title','Online Classes')
@section('page_title','Online Classes')
@section('breadcrumb','Manage online class sessions')

@section('content')
<div class="flex items-center justify-between mb-5">
    <p class="text-slate-500 text-sm">{{ $classes->total() }} total</p>
    <a href="{{ route('admin.online-classes.create') }}" class="btn-primary text-sm">
        <i class="fa-solid fa-plus"></i> Add Class
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="admin-table w-full">
            <thead><tr>
                <th class="text-left">Title</th>
                <th class="text-left hidden sm:table-cell">Class</th>
                <th class="text-left hidden md:table-cell">Scheduled</th>
                <th class="text-left hidden lg:table-cell">Platform</th>
                <th class="text-center">Status</th>
                <th class="text-center">Actions</th>
            </tr></thead>
            <tbody>
                @forelse($classes as $oc)
                <tr>
                    <td>
                        <p class="font-semibold text-navy-900 text-sm">{{ $oc->title }}</p>
                        <p class="text-xs text-slate-400">{{ $oc->duration_minutes }} min</p>
                    </td>
                    <td class="hidden sm:table-cell text-sm text-slate-500">{{ $oc->gradeClass?->full_name ?? '—' }}</td>
                    <td class="hidden md:table-cell text-sm text-slate-500">{{ $oc->scheduled_at->format('M d, Y · h:i A') }}</td>
                    <td class="hidden lg:table-cell text-sm text-slate-400 capitalize">{{ str_replace('_',' ',$oc->platform) }}</td>
                    <td class="text-center">
                        <span class="badge {{ $oc->is_active ? 'badge-active' : 'badge-inactive' }}">
                            {{ $oc->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <div class="flex items-center justify-center gap-1.5">
                            <a href="{{ route('admin.online-classes.edit', $oc) }}" class="w-8 h-8 bg-navy-50 hover:bg-navy-100 text-navy-600 rounded-lg flex items-center justify-center">
                                <i class="fa-solid fa-pen text-xs"></i>
                            </a>
                            <form action="{{ route('admin.online-classes.destroy', $oc) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button data-confirm="Delete this class?" class="w-8 h-8 bg-red-50 hover:bg-red-100 text-red-500 rounded-lg flex items-center justify-center">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-12 text-slate-400">No online classes yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($classes->hasPages())<div class="px-5 py-4 border-t border-slate-100">{{ $classes->links() }}</div>@endif
</div>
@endsection