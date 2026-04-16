@extends('layouts.admin')
@section('title','Students')
@section('page_title','Students')
@section('breadcrumb','Manage all students')

@section('content')
<div class="flex flex-wrap items-center justify-between gap-3 mb-5">
    <form method="GET" class="flex gap-3 flex-wrap">
        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Search name, index, email..."
            class="form-input w-64 text-sm">
        <select name="status" onchange="this.form.submit()" class="form-input text-sm w-36">
            <option value="">All Status</option>
            <option value="active"   {{ request('status') === 'active'   ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            <option value="pending"  {{ request('status') === 'pending'  ? 'selected' : '' }}>Pending</option>
        </select>
        <button type="submit" class="btn-primary text-sm px-4">Search</button>
    </form>
    <a href="{{ route('admin.students.create') }}" class="btn-primary text-sm">
        <i class="fa-solid fa-plus"></i> Add Student
    </a>
</div>

{{-- Pending Badge --}}
@php $pendingCount = \App\Models\User::where('user_type','student')->where('reg_status','pending')->count(); @endphp
@if($pendingCount > 0)
<div class="bg-amber-50 border border-amber-200 rounded-xl px-4 py-3 mb-5 flex items-center gap-3">
    <i class="fa-solid fa-clock text-amber-500"></i>
    <p class="text-amber-700 text-sm font-semibold">{{ $pendingCount }} student registration(s) waiting for approval.</p>
</div>
@endif

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="admin-table w-full">
            <thead>
                <tr>
                    <th class="text-left">Student</th>
                    <th class="text-left hidden sm:table-cell">Index No</th>
                    <th class="text-left hidden md:table-cell">Phone</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                <tr class="{{ $student->reg_status === 'pending' ? 'bg-amber-50/40' : '' }}">

                    {{-- Student Info --}}
                    <td>
                        <div class="flex items-center gap-3">
                            <img src="{{ $student->avatar_url }}" class="w-8 h-8 rounded-lg object-cover" alt="">
                            <div>
                                <p class="font-semibold text-navy-900 text-sm">{{ $student->name }}</p>
                                <p class="text-xs text-slate-400">{{ $student->email ?? '—' }}</p>
                            </div>
                        </div>
                    </td>

                    {{-- Index No --}}
                    <td class="hidden sm:table-cell text-sm text-slate-500 font-mono">
                        {{ $student->index_number ?? '—' }}
                    </td>

                    {{-- Phone --}}
                    <td class="hidden md:table-cell text-sm text-slate-500">
                        {{ $student->phone ?? '—' }}
                    </td>

                    {{-- Status --}}
                    <td class="text-center">
                        @if($student->reg_status === 'pending')
                            <span class="badge badge-pending">Pending</span>
                        @elseif($student->reg_status === 'rejected')
                            <span class="badge badge-inactive">Rejected</span>
                        @else
                            <span class="badge {{ $student->is_active ? 'badge-active' : 'badge-inactive' }}">
                                {{ $student->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        @endif
                    </td>

                    {{-- Actions --}}
                    <td>
                        <div class="flex items-center justify-center gap-1.5 flex-wrap">

                            @if($student->reg_status === 'pending')
                                {{-- Approve --}}
                                <form action="{{ route('admin.students.approve', $student) }}" method="POST" class="inline">
                                    @csrf
                                    <button class="flex items-center gap-1 px-2.5 h-8 bg-green-50 hover:bg-green-100 text-green-600 rounded-lg text-xs font-semibold">
                                        <i class="fa-solid fa-check text-xs"></i> Approve
                                    </button>
                                </form>
                                {{-- Reject --}}
                                <form action="{{ route('admin.students.reject', $student) }}" method="POST" class="inline">
                                    @csrf
                                    <button data-confirm="Reject {{ $student->name }}?" class="flex items-center gap-1 px-2.5 h-8 bg-red-50 hover:bg-red-100 text-red-500 rounded-lg text-xs font-semibold">
                                        <i class="fa-solid fa-xmark text-xs"></i> Reject
                                    </button>
                                </form>
                            @else
                                {{-- Edit --}}
                                <a href="{{ route('admin.students.edit', $student) }}"
                                    class="w-8 h-8 bg-navy-50 hover:bg-navy-100 text-navy-600 rounded-lg flex items-center justify-center"
                                    title="Edit">
                                    <i class="fa-solid fa-pen text-xs"></i>
                                </a>
                                {{-- Toggle Active --}}
                                <form action="{{ route('admin.students.toggle-active', $student) }}" method="POST" class="inline">
                                    @csrf
                                    <button class="w-8 h-8 {{ $student->is_active ? 'bg-amber-50 hover:bg-amber-100 text-amber-500' : 'bg-green-50 hover:bg-green-100 text-green-500' }} rounded-lg flex items-center justify-center"
                                        title="{{ $student->is_active ? 'Deactivate' : 'Activate' }}">
                                        <i class="fa-solid {{ $student->is_active ? 'fa-ban' : 'fa-check' }} text-xs"></i>
                                    </button>
                                </form>
                            @endif

                            {{-- Delete --}}
                            <form action="{{ route('admin.students.destroy', $student) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button data-confirm="Delete student {{ $student->name }}?"
                                    class="w-8 h-8 bg-red-50 hover:bg-red-100 text-red-500 rounded-lg flex items-center justify-center"
                                    title="Delete">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-12 text-slate-400">No students found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($students->hasPages())
    <div class="px-5 py-4 border-t border-slate-100">{{ $students->links() }}</div>
    @endif
</div>
@endsection