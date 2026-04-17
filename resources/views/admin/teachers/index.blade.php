@extends('layouts.admin')
@section('title','Teachers')
@section('page_title','Teachers')
@section('breadcrumb','Manage all teachers')

@section('content')
<div class="flex items-center justify-between mb-5">
    <p class="text-slate-500 text-sm">{{ $teachers->count() }} teachers total</p>
    <a href="{{ route('admin.teachers.create') }}" class="btn-primary text-sm py-2">
        <i class="fa-solid fa-plus"></i> Add Teacher
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="admin-table w-full">
            <thead><tr>
                <th class="text-left">Teacher</th>
                <th class="text-left hidden sm:table-cell">Subjects</th>
                <th class="text-left hidden md:table-cell">Contact</th>
                <th class="text-center hidden lg:table-cell">Classes</th>
                <th class="text-center">Status</th>
                <th class="text-center">Actions</th>
            </tr></thead>
            <tbody>
                @forelse($teachers as $teacher)
                <tr>
                    <td>
                        <div class="flex items-center gap-3">
                            @if($teacher->photo)
                            <img src="{{ Storage::url($teacher->photo) }}" class="w-10 h-10 rounded-full object-cover border border-slate-200 shrink-0" alt="">
                            @else
                            <div class="w-10 h-10 bg-navy-100 rounded-full flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-user text-navy-400"></i>
                            </div>
                            @endif
                            <div>
                                <p class="font-semibold text-navy-900 text-sm">{{ $teacher->name }}</p>
                                @if($teacher->email)<p class="text-xs text-slate-400">{{ $teacher->email }}</p>@endif
                            </div>
                        </div>
                    </td>
                    <td class="hidden sm:table-cell text-sm text-slate-500">
                        {{ $teacher->subjects ?? '—' }}
                    </td>
                    <td class="hidden md:table-cell text-sm text-slate-500">
                        {{ $teacher->phone ?? '—' }}
                    </td>
                    <td class="hidden lg:table-cell text-center">
                        <span class="text-sm font-semibold text-navy-700">{{ $teacher->grade_classes_count }}</span>
                        <span class="text-xs text-slate-400 ml-1">classes</span>
                    </td>
                    <td class="text-center">
                        <span class="badge {{ $teacher->is_active ? 'badge-active' : 'badge-inactive' }}">
                            {{ $teacher->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.teachers.edit', $teacher) }}"
                               class="w-8 h-8 bg-navy-50 hover:bg-navy-100 text-navy-600 rounded-lg flex items-center justify-center transition-colors"
                               data-tooltip="Edit">
                                <i class="fa-solid fa-pen text-xs"></i>
                            </a>
                            <form action="{{ route('admin.teachers.toggle', $teacher) }}" method="POST" class="inline">
                                @csrf @method('PATCH')
                                <button type="submit"
                                        class="w-8 h-8 {{ $teacher->is_active ? 'bg-amber-50 hover:bg-amber-100 text-amber-600' : 'bg-green-50 hover:bg-green-100 text-green-600' }} rounded-lg flex items-center justify-center transition-colors">
                                    <i class="fa-solid {{ $teacher->is_active ? 'fa-eye-slash' : 'fa-eye' }} text-xs"></i>
                                </button>
                            </form>
                            <form action="{{ route('admin.teachers.destroy', $teacher) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button data-confirm="Delete '{{ $teacher->name }}'?"
                                        class="w-8 h-8 bg-red-50 hover:bg-red-100 text-red-500 rounded-lg flex items-center justify-center transition-colors">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-12 text-slate-400">
                        No teachers yet. <a href="{{ route('admin.teachers.create') }}" class="text-navy-600 font-medium">Add your first teacher →</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection