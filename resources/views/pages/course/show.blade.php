@extends('layouts.app')
@section('title', $course->title)

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <nav class="flex items-center gap-2 text-sm text-slate-400 mb-6">
        <a href="{{ route('courses.index') }}" class="hover:text-navy-700">Courses</a>
        <i class="fa-solid fa-chevron-right text-xs"></i>
        <span class="text-navy-700">{{ $course->title }}</span>
    </nav>

    <div class="grid lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
       <div class="bg-gradient-to-r from-navy-800 to-navy-950 px-6 py-10 text-white relative overflow-hidden">
    @php $img = $course->thumbnail ?? $course->image ?? null; @endphp
    @if($img)
    <img src="{{ asset('storage/' . $img) }}"
         alt="{{ $course->title }}"
         class="absolute inset-0 w-full h-full object-cover opacity-20 lightbox-trigger"
         onerror="this.style.display='none'">
    @endif
    <div class="relative z-10">
        @if($course->category)
        <span class="bg-gold-500/20 text-gold-400 text-xs font-bold px-3 py-1 rounded-full border border-gold-500/30 mb-3 inline-block">{{ $course->category->name }}</span>
        @endif
        <h1 class="text-2xl font-extrabold mb-2">{{ $course->title }}</h1>
        <div class="flex flex-wrap gap-4 text-sm text-white/60">
            @if($course->duration)<span><i class="fa-regular fa-clock mr-1"></i>{{ $course->duration }}</span>@endif
            @if($course->level)<span><i class="fa-solid fa-signal mr-1"></i>{{ $course->level }}</span>@endif
        </div>
    </div>
</div>
            @if($course->syllabus)
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h3 class="font-bold text-navy-900 mb-4"><i class="fa-solid fa-list-check text-gold-500 mr-2"></i>Course Syllabus</h3>
                <div class="text-slate-600 text-sm leading-relaxed whitespace-pre-line">{{ $course->syllabus }}</div>
            </div>
            @endif

            @if($related->count())
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h3 class="font-bold text-navy-900 mb-4">Related Courses</h3>
                <div class="space-y-3">
                    @foreach($related as $r)
                    <a href="{{ route('courses.show', $r) }}" class="flex items-center gap-4 hover:bg-navy-50 rounded-xl p-3 transition-colors">
                        <div class="w-10 h-10 bg-navy-100 rounded-xl flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-book text-navy-600"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-navy-900 text-sm">{{ $r->title }}</p>
                            <p class="text-xs text-slate-400">{{ $r->duration }} · {{ $r->level }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div>
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sticky top-24">
                @if($course->fee)
                <div class="text-center mb-5 pb-5 border-b border-slate-100">
                    <p class="text-slate-400 text-sm">Course Fee</p>
                    <p class="text-3xl font-extrabold text-navy-900 mt-1">Rs. {{ number_format($course->fee) }}</p>
                </div>
                @endif
                <div class="space-y-3 text-sm mb-5">
                    @if($course->duration)
                    <div class="flex items-center gap-3 text-slate-600">
                        <i class="fa-regular fa-clock text-navy-400 w-5"></i>
                        <span>{{ $course->duration }}</span>
                    </div>
                    @endif
                    @if($course->level)
                    <div class="flex items-center gap-3 text-slate-600">
                        <i class="fa-solid fa-signal text-navy-400 w-5"></i>
                        <span>{{ $course->level }}</span>
                    </div>
                    @endif
                </div>
                <a href="https://wa.me/94784161920?text=I want to enrol in {{ urlencode($course->title) }}" target="_blank" class="btn-gold w-full justify-center mb-3">
                    <i class="fa-brands fa-whatsapp"></i> Enrol via WhatsApp
                </a>
                <a href="{{ route('contact') }}" class="btn-primary w-full justify-center text-sm">
                    <i class="fa-solid fa-envelope"></i> Send Enquiry
                </a>
            </div>
        </div>
    </div>
</div>
@endsection