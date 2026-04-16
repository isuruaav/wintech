@extends('layouts.admin')
@section('title','Courses')
@section('page_title','Courses')
@section('breadcrumb','Manage all courses')

@section('content')
<div class="flex items-center justify-between mb-5">
    <p class="text-slate-500 text-sm">{{ $courses->total() }} total</p>
    <a href="{{ route('admin.courses.create') }}" class="btn-primary text-sm">
        <i class="fa-solid fa-plus"></i> Add Course
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="admin-table w-full">
            <thead><tr>
                <th class="text-left">Course</th>
                <th class="text-left hidden sm:table-cell">Category</th>
                <th class="text-left hidden md:table-cell">Duration</th>
                <th class="text-left hidden lg:table-cell">Fee</th>
                <th class="text-center">Status</th>
                <th class="text-center">Actions</th>
            </tr></thead>
            <tbody>
                @forelse($courses as $course)
                <tr>
                    <td>
                        <p class="font-semibold text-navy-900 text-sm">{{ $course->title }}</p>
                        @if($course->level)<p class="text-xs text-slate-400">{{ $course->level }}</p>@endif
                    </td>
                    <td class="hidden sm:table-cell text-sm text-slate-500">{{ $course->category?->name ?? '—' }}</td>
                    <td class="hidden md:table-cell text-sm text-slate-500">{{ $course->duration ?? '—' }}</td>
                    <td class="hidden lg:table-cell text-sm text-slate-500">{{ $course->fee ? 'Rs. '.number_format($course->fee) : '—' }}</td>
                    <td class="text-center">
                        <span class="badge {{ $course->is_active ? 'badge-active' : 'badge-inactive' }}">
                            {{ $course->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <div class="flex items-center justify-center gap-1.5">
                            <a href="{{ route('admin.courses.edit', $course) }}" class="w-8 h-8 bg-navy-50 hover:bg-navy-100 text-navy-600 rounded-lg flex items-center justify-center">
                                <i class="fa-solid fa-pen text-xs"></i>
                            </a>
                            <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button data-confirm="Delete {{ $course->title }}?" class="w-8 h-8 bg-red-50 hover:bg-red-100 text-red-500 rounded-lg flex items-center justify-center">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-12 text-slate-400">No courses yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($courses->hasPages())<div class="px-5 py-4 border-t border-slate-100">{{ $courses->links() }}</div>@endif
</div>
@endsection