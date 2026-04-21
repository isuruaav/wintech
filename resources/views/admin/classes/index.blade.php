@extends('layouts.admin')
@section('title','Grade Classes')
@section('page_title','Grade Classes')
@section('breadcrumb','Manage all grade-wise class schedules')

@section('content')
<div class="flex flex-wrap items-center justify-between gap-3 mb-5">
    <form method="GET" class="flex flex-wrap gap-2">
        <select name="subject" class="form-input py-1.5 text-sm w-auto" onchange="this.form.submit()">
            <option value="">All Subjects</option>
            @foreach($subjects as $s)
            <option value="{{ $s }}" {{ request('subject') == $s ? 'selected' : '' }}>{{ $s }}</option>
            @endforeach
        </select>
        <select name="grade" class="form-input py-1.5 text-sm w-auto" onchange="this.form.submit()">
            <option value="">All Grades</option>
            @foreach($grades as $g)
            <option value="{{ $g }}" {{ request('grade') == $g ? 'selected' : '' }}>{{ $g }}</option>
            @endforeach
        </select>
        @if(request()->hasAny(['subject','grade']))
        <a href="{{ route('admin.classes.index') }}" class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-500 text-sm hover:bg-slate-50 transition-colors">Clear</a>
        @endif
    </form>
    <a href="{{ route('admin.classes.create') }}" class="btn-primary text-sm py-2">
        <i class="fa-solid fa-plus"></i> Add Class
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="admin-table w-full">
            <thead><tr>
                <th class="text-left">Class</th>
                <th class="text-left hidden sm:table-cell">Teacher</th>
                <th class="text-left hidden md:table-cell">Medium</th>
                <th class="text-left hidden lg:table-cell">Schedule</th>
                <th class="text-left hidden xl:table-cell">Fee</th>
                <th class="text-center">Status</th>
                <th class="text-center">Actions</th>
            </tr></thead>
            <tbody>
                @forelse($classes as $class)
                <tr>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-navy-100 rounded-lg flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-chalkboard text-navy-500 text-sm"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-navy-900 text-sm">{{ $class->subject }}</p>
                                <p class="text-xs text-slate-400">{{ $class->grade }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="hidden sm:table-cell text-sm text-slate-600">
                        <i class="fa-solid fa-chalkboard-user text-navy-300 mr-1 text-xs"></i>{{ $class->teacher }}
                    </td>
                    <td class="hidden md:table-cell">
                        @if($class->medium === 'english')
                            <span class="badge badge-active">English Medium</span>
                        @elseif($class->medium === 'sinhala')
                            <span class="badge badge-pending">Sinhala Medium</span>
                        @else
                            <span class="badge" style="background:#e0f2fe;color:#0369a1">Both</span>
                        @endif
                    </td>
                    <td class="hidden lg:table-cell">
                        @foreach($class->schedules->take(2) as $s)
                        <p class="text-xs text-slate-500">
                            <i class="fa-regular fa-calendar text-navy-300 mr-1"></i>
                            {{ $s->day }} · {{ \Carbon\Carbon::parse($s->start_time)->format('h:i A') }}–{{ \Carbon\Carbon::parse($s->end_time)->format('h:i A') }}
                        </p>
                        @endforeach
                        @if($class->schedules->count() > 2)
                        <p class="text-xs text-slate-400">+{{ $class->schedules->count() - 2 }} more</p>
                        @endif
                        @if($class->schedules->count() === 0)
                        <span class="text-xs text-slate-300">—</span>
                        @endif
                    </td>
                    <td class="hidden xl:table-cell text-sm text-slate-600">
                        {{ $class->monthly_fee ? 'Rs. '.number_format($class->monthly_fee) : '—' }}
                    </td>
                    <td class="text-center">
                        <span class="badge {{ $class->is_active ? 'badge-active' : 'badge-inactive' }}">
                            {{ $class->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.classes.edit', $class->id) }}"
                               class="w-8 h-8 bg-navy-50 hover:bg-navy-100 text-navy-600 rounded-lg flex items-center justify-center transition-colors"
                               data-tooltip="Edit">
                                <i class="fa-solid fa-pen text-xs"></i>
                            </a>
                            <form action="{{ route('admin.classes.toggle', $class->id) }}" method="POST" class="inline">
                                @csrf @method('PATCH')
                                <button type="submit"
                                        class="w-8 h-8 {{ $class->is_active ? 'bg-amber-50 hover:bg-amber-100 text-amber-600' : 'bg-green-50 hover:bg-green-100 text-green-600' }} rounded-lg flex items-center justify-center transition-colors">
                                    <i class="fa-solid {{ $class->is_active ? 'fa-eye-slash' : 'fa-eye' }} text-xs"></i>
                                </button>
                            </form>
                            <form action="{{ route('admin.classes.destroy', $class->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button data-confirm="Delete '{{ $class->grade }} — {{ $class->subject }}'?"
                                        class="w-8 h-8 bg-red-50 hover:bg-red-100 text-red-500 rounded-lg flex items-center justify-center transition-colors">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-12 text-slate-400">
                        No classes found. <a href="{{ route('admin.classes.create') }}" class="text-navy-600 font-medium">Add your first class →</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection