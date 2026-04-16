@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page_title', 'Dashboard')
@section('breadcrumb', 'Welcome back, ' . Auth::user()->name)

@section('content')

{{-- Stats Grid --}}
<div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 mb-6">
    @foreach([
        ['label'=>'Students',       'value'=>$stats['students'],         'icon'=>'fa-users',          'color'=>'bg-blue-500'],
        ['label'=>'Courses',        'value'=>$stats['courses'],          'icon'=>'fa-book',           'color'=>'bg-navy-600'],
        ['label'=>'Grade Classes',  'value'=>$stats['grade_classes'],    'icon'=>'fa-chalkboard',     'color'=>'bg-purple-500'],
        ['label'=>'Online Classes', 'value'=>$stats['upcoming_classes'], 'icon'=>'fa-video',          'color'=>'bg-green-500'],
        ['label'=>'New Enquiries',  'value'=>$stats['new_enquiries'],    'icon'=>'fa-inbox',          'color'=>'bg-amber-500'],
        ['label'=>'Exams',          'value'=>$stats['exams'],            'icon'=>'fa-file-pen',       'color'=>'bg-rose-500'],
    ] as $stat)
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-9 h-9 {{ $stat['color'] }} rounded-xl flex items-center justify-center">
                <i class="fa-solid {{ $stat['icon'] }} text-white text-sm"></i>
            </div>
        </div>
        <p class="text-2xl font-extrabold text-navy-900">{{ $stat['value'] }}</p>
        <p class="text-slate-400 text-xs mt-0.5">{{ $stat['label'] }}</p>
    </div>
    @endforeach
</div>

<div class="grid lg:grid-cols-3 gap-6">

    {{-- Recent Students --}}
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
            <h3 class="font-bold text-navy-900">Recent Students</h3>
            <a href="{{ route('admin.students.index') }}" class="text-xs text-navy-600 hover:text-gold-500 font-semibold">View All →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="admin-table w-full">
                <thead><tr>
                    <th class="text-left">Name</th>
                    <th class="text-left hidden sm:table-cell">Index No</th>
                    <th class="text-center">Status</th>
                </tr></thead>
                <tbody>
                    @forelse($recentStudents as $s)
                    <tr>
                        <td>
                            <div class="flex items-center gap-3">
                                <img src="{{ $s->avatar_url }}" class="w-8 h-8 rounded-lg object-cover" alt="">
                                <div>
                                    <p class="font-semibold text-navy-900 text-sm">{{ $s->name }}</p>
                                    <p class="text-xs text-slate-400">{{ $s->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="hidden sm:table-cell text-sm text-slate-500">{{ $s->index_number ?? '—' }}</td>
                        <td class="text-center">
                            <span class="badge {{ $s->is_active ? 'badge-active' : 'badge-inactive' }}">
                                {{ $s->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="text-center py-8 text-slate-400">No students yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Right Column --}}
    <div class="space-y-5">

        {{-- Upcoming Classes --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                <h3 class="font-bold text-navy-900 text-sm">Upcoming Classes</h3>
                <a href="{{ route('admin.online-classes.index') }}" class="text-xs text-navy-600 hover:text-gold-500 font-semibold">All →</a>
            </div>
            <div class="p-4 space-y-3">
                @forelse($upcomingClasses as $oc)
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 bg-navy-100 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                        <i class="fa-solid fa-video text-navy-600 text-xs"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-navy-900 leading-tight">{{ Str::limit($oc->title, 30) }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">{{ $oc->scheduled_at->format('M d · h:i A') }}</p>
                    </div>
                </div>
                @empty
                <p class="text-sm text-slate-400 text-center py-2">No upcoming classes.</p>
                @endforelse
            </div>
        </div>

        {{-- New Enquiries --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                <h3 class="font-bold text-navy-900 text-sm">New Enquiries</h3>
                <a href="{{ route('admin.enquiries.index') }}" class="text-xs text-navy-600 hover:text-gold-500 font-semibold">All →</a>
            </div>
            <div class="p-4 space-y-3">
                @forelse($newEnquiries as $enq)
                <a href="{{ route('admin.enquiries.show', $enq) }}" class="flex items-start gap-3 hover:bg-slate-50 rounded-xl p-2 -m-2 transition-colors">
                    <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                        <i class="fa-solid fa-envelope text-amber-600 text-xs"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-navy-900 leading-tight">{{ $enq->name }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">{{ Str::limit($enq->subject ?? $enq->message, 28) }}</p>
                    </div>
                </a>
                @empty
                <p class="text-sm text-slate-400 text-center py-2">No new enquiries.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- Quick Actions --}}
<div class="mt-6 grid grid-cols-2 sm:grid-cols-4 gap-4">
    @foreach([
        ['route'=>'admin.students.create',      'icon'=>'fa-user-plus',   'label'=>'Add Student',    'color'=>'bg-blue-50 text-blue-700 hover:bg-blue-100'],
        ['route'=>'admin.courses.create',       'icon'=>'fa-book-medical','label'=>'Add Course',     'color'=>'bg-navy-50 text-navy-700 hover:bg-navy-100'],
        ['route'=>'admin.exams.create',         'icon'=>'fa-file-pen',    'label'=>'Create Exam',    'color'=>'bg-purple-50 text-purple-700 hover:bg-purple-100'],
        ['route'=>'admin.online-classes.create','icon'=>'fa-video',       'label'=>'Add Class',      'color'=>'bg-green-50 text-green-700 hover:bg-green-100'],
    ] as $action)
    <a href="{{ route($action['route']) }}" class="{{ $action['color'] }} rounded-2xl p-5 flex flex-col items-center gap-2 transition-colors text-center">
        <i class="fa-solid {{ $action['icon'] }} text-xl"></i>
        <span class="text-sm font-semibold">{{ $action['label'] }}</span>
    </a>
    @endforeach
</div>

@endsection