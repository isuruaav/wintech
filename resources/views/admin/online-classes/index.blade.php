@extends('layouts.admin')
@section('title', 'Online Classes')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-navy-900">Online Classes</h1>
            <p class="text-slate-500 text-sm mt-1">Manage live and upcoming online classes</p>
        </div>
        <a href="{{ route('admin.online-classes.create') }}" class="btn-primary">
            <i class="fa-solid fa-plus"></i> Add Class
        </a>
    </div>

    {{-- Filter --}}
    <form method="GET" class="flex gap-3 items-center bg-white p-4 rounded-xl border border-slate-200">
        <select name="status" class="form-input text-sm py-2 rounded-lg border-slate-200 w-40">
            <option value="">All Status</option>
            <option value="upcoming" {{ request('status')=='upcoming'?'selected':'' }}>Upcoming</option>
            <option value="live"     {{ request('status')=='live'?'selected':'' }}>Live Now</option>
            <option value="ended"    {{ request('status')=='ended'?'selected':'' }}>Ended</option>
        </select>
        <button type="submit" class="btn-primary text-sm py-2 px-4">Filter</button>
        <a href="{{ route('admin.online-classes.index') }}" class="text-sm text-slate-500 hover:text-navy-700">Clear</a>
    </form>

    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="text-left px-5 py-3 font-semibold text-slate-600">Title</th>
                    <th class="text-left px-5 py-3 font-semibold text-slate-600">Platform</th>
                    <th class="text-left px-5 py-3 font-semibold text-slate-600">Grade Class</th>
                    <th class="text-left px-5 py-3 font-semibold text-slate-600">Scheduled</th>
                    <th class="text-left px-5 py-3 font-semibold text-slate-600">Duration</th>
                    <th class="text-left px-5 py-3 font-semibold text-slate-600">Status</th>
                    <th class="text-right px-5 py-3 font-semibold text-slate-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($classes as $oc)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-5 py-3">
                        <p class="font-semibold text-navy-900">{{ $oc->title }}</p>
                        @if($oc->description)
                        <p class="text-slate-400 text-xs mt-0.5 line-clamp-1">{{ $oc->description }}</p>
                        @endif
                    </td>
                    <td class="px-5 py-3">
                        @php
                        $platforms = ['zoom'=>'Zoom','google_meet'=>'Google Meet','teams'=>'MS Teams','other'=>'Other'];
                        $pColors   = ['zoom'=>'bg-blue-100 text-blue-700','google_meet'=>'bg-green-100 text-green-700','teams'=>'bg-indigo-100 text-indigo-700','other'=>'bg-slate-100 text-slate-700'];
                        @endphp
                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $pColors[$oc->platform] ?? 'bg-slate-100 text-slate-700' }}">
                            {{ $platforms[$oc->platform] ?? $oc->platform }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-slate-600">
                        {{ $oc->gradeClass ? $oc->gradeClass->subject.' - Grade '.$oc->gradeClass->grade : '—' }}
                    </td>
                    <td class="px-5 py-3 text-slate-600">
                        <p>{{ $oc->scheduled_at->format('M d, Y') }}</p>
                        <p class="text-xs text-slate-400">{{ $oc->scheduled_at->format('h:i A') }}</p>
                    </td>
                    <td class="px-5 py-3 text-slate-600">{{ $oc->duration_minutes }} min</td>
                    <td class="px-5 py-3">
                        @php
                        $sColors = ['upcoming'=>'bg-blue-100 text-blue-700','live'=>'bg-green-100 text-green-700','ended'=>'bg-slate-100 text-slate-500'];
                        @endphp
                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $sColors[$oc->status] ?? 'bg-slate-100 text-slate-700' }}">
                            @if($oc->status === 'live')
                            <span class="inline-block w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse mr-1"></span>
                            @endif
                            {{ ucfirst($oc->status) }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ $oc->join_url }}" target="_blank"
                               class="text-xs px-2 py-1 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 transition-colors"
                               title="Join">
                                <i class="fa-solid fa-link"></i>
                            </a>
                            <a href="{{ route('admin.online-classes.edit', $oc) }}"
                               class="text-xs px-2 py-1 bg-navy-50 text-navy-700 rounded-lg hover:bg-navy-100 transition-colors">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.online-classes.destroy', $oc) }}"
                                  onsubmit="return confirm('Delete this class?')">
                                @csrf @method('DELETE')
                                <button class="text-xs px-2 py-1 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-5 py-10 text-center text-slate-400">
                        <i class="fa-solid fa-video text-3xl mb-3 block opacity-30"></i>
                        No online classes found.
                        <a href="{{ route('admin.online-classes.create') }}" class="text-navy-600 font-semibold ml-1">Add one</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($classes->hasPages())
        <div class="px-5 py-4 border-t border-slate-100">
            {{ $classes->links() }}
        </div>
        @endif
    </div>
</div>
@endsection