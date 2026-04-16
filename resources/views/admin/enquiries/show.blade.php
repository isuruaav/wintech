@extends('layouts.admin')
@section('title','View Enquiry')
@section('page_title','View Enquiry')
@section('breadcrumb','Enquiries / View')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="bg-gradient-to-r from-navy-900 to-navy-700 px-6 py-5">
            <div class="flex items-start justify-between">
                <div>
                    <h2 class="text-white font-bold text-lg">{{ $enquiry->name }}</h2>
                    <p class="text-white/50 text-sm mt-0.5">{{ $enquiry->created_at->format('F j, Y \a\t h:i A') }}</p>
                </div>
                <span class="badge {{ $enquiry->status === 'new' ? 'badge-active' : 'badge-pending' }}">{{ ucfirst($enquiry->status) }}</span>
            </div>
        </div>
        <div class="p-6 space-y-4">
            <div class="grid sm:grid-cols-2 gap-4">
                @if($enquiry->email)
                <div class="flex items-center gap-3 bg-slate-50 rounded-xl p-3">
                    <i class="fa-solid fa-envelope text-navy-400"></i>
                    <a href="mailto:{{ $enquiry->email }}" class="text-sm text-navy-700 hover:underline">{{ $enquiry->email }}</a>
                </div>
                @endif
                @if($enquiry->phone)
                <div class="flex items-center gap-3 bg-slate-50 rounded-xl p-3">
                    <i class="fa-solid fa-phone text-navy-400"></i>
                    <a href="tel:{{ $enquiry->phone }}" class="text-sm text-navy-700 hover:underline">{{ $enquiry->phone }}</a>
                </div>
                @endif
            </div>
            @if($enquiry->subject)
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1">Subject</p>
                <p class="text-navy-900 font-semibold">{{ $enquiry->subject }}</p>
            </div>
            @endif
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1">Message</p>
                <div class="bg-slate-50 rounded-xl p-4 text-slate-700 text-sm leading-relaxed">
                    {{ $enquiry->message }}
                </div>
            </div>
        </div>
        <div class="px-6 pb-6 flex gap-3 flex-wrap">
            @if($enquiry->email)
            <a href="mailto:{{ $enquiry->email }}" class="btn-primary text-sm py-2">
                <i class="fa-solid fa-reply"></i> Reply via Email
            </a>
            @endif
            @if($enquiry->phone)
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $enquiry->phone) }}" target="_blank"
               class="flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white font-semibold text-sm px-4 py-2 rounded-lg transition-colors">
                <i class="fa-brands fa-whatsapp"></i> WhatsApp
            </a>
            @endif
            <a href="{{ route('admin.enquiries.index') }}" class="px-4 py-2 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 text-sm font-medium transition-colors ml-auto">
                <i class="fa-solid fa-arrow-left mr-1"></i> Back
            </a>
        </div>
    </div>
</div>
@endsection