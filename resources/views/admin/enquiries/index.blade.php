@extends('layouts.admin')
@section('title','Enquiries')
@section('page_title','Enquiries')
@section('breadcrumb','Contact form submissions')

@section('content')
<div class="flex items-center justify-between mb-5">
    <form method="GET" class="flex gap-3">
        <select name="status" onchange="this.form.submit()" class="form-input text-sm w-36">
            <option value="">All Status</option>
            <option value="new"     {{ request('status') === 'new'     ? 'selected' : '' }}>New</option>
            <option value="read"    {{ request('status') === 'read'    ? 'selected' : '' }}>Read</option>
            <option value="replied" {{ request('status') === 'replied' ? 'selected' : '' }}>Replied</option>
        </select>
    </form>
    <p class="text-slate-500 text-sm">{{ $enquiries->total() }} total</p>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="admin-table w-full">
            <thead><tr>
                <th class="text-left">Name</th>
                <th class="text-left hidden sm:table-cell">Contact</th>
                <th class="text-left hidden md:table-cell">Subject</th>
                <th class="text-left hidden lg:table-cell">Date</th>
                <th class="text-center">Status</th>
                <th class="text-center">Actions</th>
            </tr></thead>
            <tbody>
                @forelse($enquiries as $enq)
                <tr class="{{ $enq->status === 'new' ? 'bg-amber-50/50' : '' }}">
                    <td>
                        <p class="font-semibold text-navy-900 text-sm {{ $enq->status === 'new' ? 'font-bold' : '' }}">{{ $enq->name }}</p>
                    </td>
                    <td class="hidden sm:table-cell text-sm text-slate-500">
                        <div>{{ $enq->email }}</div>
                        <div>{{ $enq->phone }}</div>
                    </td>
                    <td class="hidden md:table-cell text-sm text-slate-500 max-w-xs truncate">{{ $enq->subject ?? Str::limit($enq->message, 40) }}</td>
                    <td class="hidden lg:table-cell text-sm text-slate-400">{{ $enq->created_at->format('M d, Y') }}</td>
                    <td class="text-center">
                        <span class="badge {{ $enq->status === 'new' ? 'badge-active' : ($enq->status === 'replied' ? 'badge-inactive' : 'badge-pending') }}">
                            {{ ucfirst($enq->status) }}
                        </span>
                    </td>
                    <td>
                        <div class="flex items-center justify-center gap-1.5">
                            <a href="{{ route('admin.enquiries.show', $enq) }}" class="w-8 h-8 bg-navy-50 hover:bg-navy-100 text-navy-600 rounded-lg flex items-center justify-center">
                                <i class="fa-solid fa-eye text-xs"></i>
                            </a>
                            <form action="{{ route('admin.enquiries.destroy', $enq) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button data-confirm="Delete enquiry from {{ $enq->name }}?" class="w-8 h-8 bg-red-50 hover:bg-red-100 text-red-500 rounded-lg flex items-center justify-center">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-12 text-slate-400">No enquiries yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($enquiries->hasPages())<div class="px-5 py-4 border-t border-slate-100">{{ $enquiries->links() }}</div>@endif
</div>
@endsection