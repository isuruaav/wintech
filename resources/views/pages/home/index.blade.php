

@extends('layouts.app')
@section('title', 'Home')

@section('content')

{{-- ===== HERO ===== --}}
<section class="relative min-h-screen flex items-center pt-16 overflow-hidden">

    {{-- Background Image + Overlay --}}
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/hero-bg.jpg') }}"
             onerror="this.style.display='none'"
             class="w-full h-full object-cover object-center" alt="">
        <div class="absolute inset-0 bg-gradient-to-br from-navy-950/95 via-navy-900/90 to-navy-800/85"></div>
    </div>

    {{-- Animated Grid Pattern --}}
    <div class="absolute inset-0 z-0 opacity-10"
         style="background-image: linear-gradient(rgba(240,165,0,0.3) 1px, transparent 1px),
                linear-gradient(90deg, rgba(240,165,0,0.3) 1px, transparent 1px);
                background-size: 60px 60px;">
    </div>

    {{-- Glowing Orbs --}}
    <div class="absolute top-1/4 right-1/4 w-96 h-96 bg-gold-500/10 rounded-full blur-3xl z-0 animate-pulse"></div>
    <div class="absolute bottom-1/4 left-1/4 w-64 h-64 bg-navy-400/20 rounded-full blur-3xl z-0"></div>

    {{-- Content --}}
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 w-full">
        <div class="grid lg:grid-cols-2 gap-16 items-center">

            {{-- Left --}}
            <div class="reveal">
                <div class="inline-flex items-center gap-2 bg-gold-500/15 text-gold-400 text-xs font-bold px-4 py-2 rounded-full border border-gold-500/30 mb-8 backdrop-blur-sm">
                    <span class="w-2 h-2 bg-gold-400 rounded-full animate-pulse"></span>
                    No.1 IT Institute in Moragollagama
                </div>

         <h1 class="text-5xl sm:text-6xl lg:text-7xl font-extrabold text-white leading-[1.05] mb-6 tracking-tight">
    
    <span class="block">Empower</span>

    <span class="relative inline-block">
        <span class="text-transparent bg-clip-text animate-gradient bg-[length:200%_200%]"
              style="background-image: linear-gradient(135deg, #f0a400, #fbd96a, #f0a400);">
            Your Future
        </span>

        <!-- Glow Effect -->
        <span class="absolute inset-0 blur-xl opacity-30 bg-gradient-to-r from-yellow-400 via-amber-300 to-yellow-400"></span>
    </span>

    <span class="block text-white/80 text-4xl sm:text-5xl font-light mt-2">
        Through Technology
    </span>

    </h1>


                <p class="text-white/60 text-lg leading-relaxed mb-10 max-w-lg">
                    WinTech Institute offers industry-leading IT courses, grade classes and professional training — shaping careers since 2015.
                </p>

                <div class="flex flex-wrap gap-4 mb-12">
                    <a href="{{ route('courses.index') }}"
                       class="group relative overflow-hidden bg-gold-500 hover:bg-gold-400 text-navy-900 font-bold px-8 py-4 rounded-2xl transition-all duration-300 flex items-center gap-3 text-base shadow-lg shadow-gold-500/30 hover:shadow-gold-500/50 hover:-translate-y-0.5">
                        <i class="fa-solid fa-rocket group-hover:rotate-12 transition-transform"></i>
                        Explore Courses
                        <i class="fa-solid fa-arrow-right text-sm group-hover:translate-x-1 transition-transform"></i>
                    </a>
                    <a href="{{ route('register') }}"
                       class="group flex items-center gap-3 bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white font-semibold px-8 py-4 rounded-2xl border border-white/20 hover:border-white/40 transition-all duration-300 text-base hover:-translate-y-0.5">
                        <i class="fa-solid fa-user-plus"></i>
                        Register Now
                    </a>
                </div>

                {{-- Quick Stats Row --}}
                <div class="flex flex-wrap gap-6">
                    @foreach([
                        [$settings['total_students'] ?? '500', 'Students', 'fa-users'],
                        [$settings['total_courses']  ?? '7',   'Courses',  'fa-book'],
                        [$settings['years_active']   ?? '10',  'Years',    'fa-calendar'],
                    ] as [$val, $label, $icon])
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/10 backdrop-blur rounded-xl flex items-center justify-center border border-white/10">
                            <i class="fa-solid {{ $icon }} text-gold-400 text-sm"></i>
                        </div>
                        <div>
                            <p class="text-white font-extrabold text-lg leading-none">{{ $val }}+</p>
                            <p class="text-white/50 text-xs">{{ $label }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Right — Feature Cards --}}
            <div class="reveal hidden lg:grid grid-cols-2 gap-4">
                @foreach([
                    ['fa-solid fa-computer',        'fa-solid fa-computer',        'IT Courses',       'Professional certifications',    'bg-blue-500/20',   'text-blue-400'],
                    ['fa-solid fa-chalkboard-user', 'fa-solid fa-chalkboard-user', 'Grade Classes',    'Grade 6 to A/L',                 'bg-purple-500/20', 'text-purple-400'],
                    ['fa-solid fa-video',           'fa-solid fa-video',           'Online Classes',   'Google Meet & Zoom',             'bg-green-500/20',  'text-green-400'],
                    ['fa-solid fa-trophy',          'fa-solid fa-trophy',          'Results Portal',   'Check anytime online',           'bg-gold-500/20',   'text-gold-400'],
                ] as $i => [$_, $icon, $title, $desc, $bg, $color])
                <div class="{{ $i === 1 || $i === 3 ? 'mt-8' : '' }} group bg-white/5 hover:bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/10 hover:border-white/20 transition-all duration-300 cursor-default hover:-translate-y-1">
                    <div class="w-12 h-12 {{ $bg }} rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <i class="{{ $icon }} {{ $color }} text-xl"></i>
                    </div>
                    <p class="text-white font-bold text-base mb-1">{{ $title }}</p>
                    <p class="text-white/50 text-sm">{{ $desc }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Bottom Wave --}}
    <div class="absolute bottom-0 left-0 right-0 z-10">
        <svg viewBox="0 0 1440 60" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,60 C360,0 1080,0 1440,60 L1440,60 L0,60 Z" fill="#f8fafc"/>
        </svg>
    </div>
</section>

{{-- ===== STATS ===== --}}
<section class="bg-slate-50 py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach([
                [$settings['total_students'] ?? 500,  '+', 'Happy Students',   'fa-users',        'bg-blue-100',   'text-blue-600'],
                [$settings['total_courses']  ?? 7,    '',  'Courses Offered',  'fa-book-open',    'bg-purple-100', 'text-purple-600'],
                [$settings['years_active']   ?? 10,   '+', 'Years Experience', 'fa-calendar-days','bg-gold-100',   'text-gold-600'],
                [$settings['total_teachers'] ?? 15,   '+', 'Expert Teachers',  'fa-chalkboard-user','bg-green-100','text-green-600'],
            ] as [$target, $suffix, $label, $icon, $bg, $color])
            <div class="reveal bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition-shadow">
                <div class="w-12 h-12 {{ $bg }} rounded-xl flex items-center justify-center shrink-0">
                    <i class="fa-solid {{ $icon }} {{ $color }} text-lg"></i>
                </div>
                <div>
                    <p class="text-3xl font-extrabold text-navy-900" data-target="{{ $target }}" data-suffix="{{ $suffix }}">0</p>
                    <p class="text-slate-500 text-xs mt-0.5">{{ $label }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== FEATURED COURSES ===== --}}
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 reveal">
            <span class="inline-block bg-navy-100 text-navy-700 text-xs font-bold px-4 py-2 rounded-full uppercase tracking-wider mb-4">What We Offer</span>
            <h2 class="text-4xl font-extrabold text-navy-900 mb-4">Featured <span class="text-gold-500">Courses</span></h2>
            <p class="text-slate-500 max-w-xl mx-auto">Industry-recognized certifications to launch your technology career.</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($featuredCourses as $course)
            <a href="{{ route('courses.show', $course) }}"
               class="group card-hover bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden reveal flex flex-col">
                {{-- Card Header --}}
             {{-- Card Header --}}
<div class="relative bg-gradient-to-br from-navy-800 to-navy-950 h-44 flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 opacity-20"
         style="background-image: radial-gradient(circle at 30% 50%, rgba(240,165,0,0.4), transparent 60%);">
    </div>

    {{-- Course Image --}}
    @if(!empty($course->thumbnail) || !empty($course->image))
    @php $imgPath = $course->thumbnail ?? $course->image; @endphp
    <img src="{{ asset('storage/' . $imgPath) }}"
         alt="{{ $course->title }}"
         class="absolute inset-0 w-full h-full object-cover opacity-80 group-hover:scale-105 transition-transform duration-500"
         onerror="this.style.display='none'">
    <div class="absolute inset-0 bg-navy-950/50"></div>
    @endif

    <i class="fa-solid fa-book-open text-gold-400 text-5xl relative z-10 group-hover:scale-110 transition-transform duration-300
        {{ (!empty($course->thumbnail) || !empty($course->image)) ? 'opacity-0' : '' }}"></i>

    @if($course->is_featured)
    <span class="absolute top-3 right-3 bg-gold-500 text-navy-900 text-xs font-bold px-3 py-1 rounded-full z-10">
        ⭐ Featured
    </span>
    @endif
    @if($course->level)
    <span class="absolute bottom-3 left-3 bg-white/10 backdrop-blur text-white text-xs font-semibold px-3 py-1 rounded-full border border-white/20 z-10">
        {{ $course->level }}
    </span>
    @endif
</div>
                {{-- Card Body --}}
                <div class="p-5 flex-1 flex flex-col">
                    @if($course->category)
                    <span class="text-xs text-navy-500 font-bold uppercase tracking-wider">{{ $course->category->name }}</span>
                    @endif
                    <h3 class="font-bold text-navy-900 text-base mt-1 mb-2 group-hover:text-gold-600 transition-colors">{{ $course->title }}</h3>
                    <p class="text-slate-500 text-sm leading-relaxed line-clamp-2 flex-1">{{ $course->description }}</p>
                    <div class="flex items-center justify-between mt-4 pt-4 border-t border-slate-100">
                        <div class="flex items-center gap-3 text-xs text-slate-400">
                            @if($course->duration)
                            <span class="flex items-center gap-1">
                                <i class="fa-regular fa-clock text-navy-400"></i>{{ $course->duration }}
                            </span>
                            @endif
                        </div>
                        @if($course->fee)
                        <span class="font-extrabold text-navy-900">Rs. {{ number_format($course->fee) }}</span>
                        @else
                        <span class="text-green-600 font-bold text-xs">Free</span>
                        @endif
                    </div>
                </div>
                {{-- Hover Arrow --}}
                <div class="px-5 pb-4">
                    <div class="flex items-center gap-2 text-navy-600 group-hover:text-gold-500 text-sm font-semibold transition-colors">
                        View Course <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform text-xs"></i>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <div class="text-center mt-10">
            <a href="{{ route('courses.index') }}" class="btn-primary text-base px-8 py-3">
                View All Courses <i class="fa-solid fa-arrow-right ml-1"></i>
            </a>
        </div>
    </div>
</section>

{{-- ══ GRADE CLASSES BANNER ════════════════════════════════════ --}}
<section class="py-16" style="background: linear-gradient(135deg, #0d1f3c 0%, #162f60 100%);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-white mb-3">Grade Classes</h2>
            <p class="text-white/50">Supporting students from Grade 6 through A/L in English, ICT, Mathematics &amp; Science</p>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            @foreach(['English' => 'fa-solid fa-language', 'ICT' => 'fa-solid fa-computer', 'Mathematics' => 'fa-solid fa-calculator', 'Science' => 'fa-solid fa-flask'] as $subject => $icon)
            <a href="{{ route('grade.index', ['subject' => $subject]) }}"
               class="group card-hover bg-white/10 border border-white/20 rounded-2xl p-5 text-center hover:bg-white/20 transition-all scroll-animate">
                <div class="w-12 h-12 mx-auto bg-gold-500/20 group-hover:bg-gold-500 rounded-xl flex items-center justify-center mb-3 transition-colors">
                    <i class="{{ $icon }} text-xl text-gold-400 group-hover:text-navy-900 transition-colors"></i>
                </div>
                <h3 class="text-white font-semibold text-sm">{{ $subject }}</h3>
                <p class="text-white/40 text-xs mt-1">Grade 6 – A/L</p>
            </a>
            @endforeach
        </div>
        <div class="text-center mt-8">
            <a href="{{ route('grade.index') }}" class="btn-gold">
                <i class="fa-solid fa-graduation-cap"></i> View All Classes
            </a>
        </div>
    </div>
</section>

{{-- ===== UPCOMING ONLINE CLASSES ===== --}}
@if($upcomingClasses->count())
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 reveal">
            <span class="inline-flex items-center gap-2 bg-red-100 text-red-600 text-xs font-bold px-4 py-2 rounded-full uppercase tracking-wider mb-4">
                <span class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></span> Join Live
            </span>
            <h2 class="text-4xl font-extrabold text-navy-900 mb-4">Upcoming <span class="text-gold-500">Online Classes</span></h2>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach($upcomingClasses as $oc)
            <div class="group card-hover bg-white rounded-2xl border border-slate-100 p-5 shadow-sm hover:border-navy-300 reveal">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 bg-navy-100 group-hover:bg-navy-900 rounded-xl flex items-center justify-center transition-colors">
                        <i class="fa-solid {{ $oc->platform_icon }} text-navy-600 group-hover:text-gold-400 transition-colors text-sm"></i>
                    </div>
                    <span class="text-xs font-bold text-white bg-navy-900 px-3 py-1 rounded-full capitalize">
                        {{ str_replace('_', ' ', $oc->platform) }}
                    </span>
                </div>
                <h3 class="font-bold text-navy-900 mb-2 leading-tight">{{ $oc->title }}</h3>
                <div class="bg-slate-50 rounded-xl px-3 py-2.5 mb-4 text-xs text-slate-600 space-y-1">
                    <p class="flex items-center gap-2">
                        <i class="fa-regular fa-calendar text-navy-400 w-3"></i>
                        {{ $oc->scheduled_at->format('M d, Y') }}
                    </p>
                    <p class="flex items-center gap-2">
                        <i class="fa-regular fa-clock text-navy-400 w-3"></i>
                        {{ $oc->scheduled_at->format('h:i A') }} · {{ $oc->duration_minutes }} min
                    </p>
                </div>
                <a href="{{ $oc->join_url }}" target="_blank"
                   class="btn-primary w-full justify-center text-xs py-2.5">
                    <i class="fa-solid fa-video text-xs"></i> Join Class
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
{{-- ══ OUR TEACHERS ═══════════════════════════════════════════ --}}
@if(isset($teachers) && $teachers->count())
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-navy-900 section-title inline-block mb-2">Meet Our Teachers</h2>
            <p class="text-slate-500 mt-4">Experienced and dedicated educators committed to your success</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($teachers as $teacher)
            <div class="card-hover bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden scroll-animate text-center">
                {{-- Photo --}}
                <div class="relative">
                    @if($teacher->photo)
                    <img src="{{ Storage::url($teacher->photo) }}"
                         alt="{{ $teacher->name }}"
                         class="w-full h-52 object-cover object-top">
                    @else
                    <div class="w-full h-52 bg-gradient-to-br from-navy-800 to-navy-950 flex items-center justify-center">
                        <i class="fa-solid fa-user text-6xl text-white/20"></i>
                    </div>
                    @endif
                    {{-- Subject badge --}}
                    @if($teacher->subjects)
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-navy-950/90 to-transparent px-4 py-3">
                        <p class="text-gold-400 text-xs font-semibold">{{ $teacher->subjects }}</p>
                    </div>
                    @endif
                </div>
                {{-- Info --}}
                <div class="p-5">
                    <h3 class="font-bold text-navy-900 text-base mb-1">{{ $teacher->name }}</h3>
                    @if($teacher->bio)
                    <p class="text-slate-500 text-xs leading-relaxed line-clamp-2 mb-3">{{ $teacher->bio }}</p>
                    @endif
                    <div class="flex items-center justify-center gap-3 text-xs text-slate-400">
                        @if($teacher->phone)
                        <a href="tel:{{ $teacher->phone }}" class="flex items-center gap-1 hover:text-navy-700 transition-colors">
                            <i class="fa-solid fa-phone text-navy-300"></i> {{ $teacher->phone }}
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
{{-- ===== WHY WINTECH ===== --}}
<section class="py-20 relative overflow-hidden bg-navy-950">
    {{-- Background Pattern --}}
    <div class="absolute inset-0 opacity-5"
         style="background-image: radial-gradient(circle, rgba(240,165,0,0.8) 1px, transparent 1px);
                background-size: 40px 40px;">
    </div>
    <div class="absolute top-0 left-1/2 w-px h-full bg-gradient-to-b from-transparent via-gold-500/20 to-transparent"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14 reveal">
            <span class="inline-block bg-gold-500/20 text-gold-400 text-xs font-bold px-4 py-2 rounded-full border border-gold-500/20 uppercase tracking-wider mb-4">Why Choose Us</span>
            <h2 class="text-4xl font-extrabold text-white mb-4">
                Why <span class="text-gold-400">WinTech?</span>
            </h2>
            <p class="text-white/50 max-w-xl mx-auto">We are committed to excellence in education and student success.</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach([
                ['fa-solid fa-certificate',     'Certified Courses',    'Industry-recognized certificates accepted by top employers nationwide.',     'bg-blue-500/20',   'text-blue-400'],
                ['fa-solid fa-chalkboard-user', 'Expert Instructors',   'Qualified and experienced teachers with real-world industry knowledge.',     'bg-purple-500/20', 'text-purple-400'],
                ['fa-solid fa-laptop',          'Hands-on Training',    'Practical lab sessions with modern equipment, tools and latest software.',   'bg-green-500/20',  'text-green-400'],
                ['fa-solid fa-clock',           'Flexible Timings',     'Morning, evening and weekend batches to fit your busy schedule.',            'bg-gold-500/20',   'text-gold-400'],
                ['fa-solid fa-wifi',            'Online & Physical',    'Attend classes from anywhere via Google Meet or Zoom — your choice.',        'bg-cyan-500/20',   'text-cyan-400'],
                ['fa-solid fa-chart-line',      'Proven Results',       'High pass rates and successful placement record for our graduates.',         'bg-rose-500/20',   'text-rose-400'],
            ] as [$icon, $title, $desc, $bg, $color])
            <div class="group reveal bg-white/3 hover:bg-white/8 backdrop-blur rounded-2xl p-6 border border-white/8 hover:border-white/20 transition-all duration-300 hover:-translate-y-1">
                <div class="w-12 h-12 {{ $bg }} rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <i class="{{ $icon }} {{ $color }} text-xl"></i>
                </div>
                <h3 class="font-bold text-white text-base mb-2">{{ $title }}</h3>
                <p class="text-white/50 text-sm leading-relaxed">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== REGISTER CTA ===== --}}
<section class="py-20 bg-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative bg-gradient-to-br from-navy-900 to-navy-950 rounded-3xl p-10 lg:p-14 overflow-hidden reveal">
            {{-- Decorative --}}
            <div class="absolute top-0 right-0 w-64 h-64 bg-gold-500/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-navy-600/30 rounded-full blur-3xl"></div>

            <div class="relative grid lg:grid-cols-2 gap-10 items-center">
                <div>
                    <span class="inline-block bg-gold-500/20 text-gold-400 text-xs font-bold px-4 py-2 rounded-full border border-gold-500/20 mb-5">Join WinTech Today</span>
                    <h2 class="text-3xl lg:text-4xl font-extrabold text-white mb-4 leading-tight">
                        Start Your Tech Journey <span class="text-gold-400">Today</span>
                    </h2>
                    <p class="text-white/60 leading-relaxed mb-6">
                        Register online and get access to all course materials, results portal, online classes and more.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('register') }}" class="btn-gold text-base px-8 py-3">
                            <i class="fa-solid fa-user-plus"></i> Register Now — Free
                        </a>
                        <a href="{{ route('contact') }}" class="flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white font-semibold px-6 py-3 rounded-xl border border-white/20 transition-colors text-sm">
                            <i class="fa-solid fa-phone"></i> Call Us
                        </a>
                    </div>
                </div>

          {{--
    Owner Card — uses SiteSetting model for dynamic data.
    Place this in your contact/about section blade.
    Make sure to import: use App\Models\SiteSetting;
    Or use the helper: \App\Models\SiteSetting::get('key')
--}}

@php
    $ownerPhoto         = \App\Models\SiteSetting::get('owner_photo');
    $ownerName          = \App\Models\SiteSetting::get('owner_name',          'Chathuranga Dissanayaka');
    $ownerTitle         = \App\Models\SiteSetting::get('owner_title',         'Founder & Director');
    $ownerQualification = \App\Models\SiteSetting::get('owner_qualification', '');
    $ownerPhone         = \App\Models\SiteSetting::get('owner_phone',         '+94 78 416 1920');
    $ownerWhatsapp      = \App\Models\SiteSetting::get('owner_whatsapp',      '94784161920');
    $ownerAddress       = \App\Models\SiteSetting::get('owner_address',       'Kiralabokkagama, Moragollagama');
@endphp

{{-- Owner Card --}}
<div class="bg-white/5 backdrop-blur rounded-2xl border border-white/10 p-6">
    <div class="flex items-center gap-4 mb-5">

        {{-- Photo or Icon --}}
        <div class="w-16 h-16 rounded-2xl shrink-0 overflow-hidden
                    {{ $ownerPhoto ? '' : 'bg-gold-500 flex items-center justify-center' }}">
            @if($ownerPhoto)
                <img src="{{ Storage::url($ownerPhoto) }}"
                     alt="{{ $ownerName }}"
                     class="w-full h-full object-cover">
            @else
                <i class="fa-solid fa-user-tie text-navy-900 text-2xl"></i>
            @endif
        </div>

        {{-- Name, Title, Qualification --}}
        <div>
            <p class="text-white font-extrabold text-lg leading-tight">{{ $ownerName }}</p>
            <p class="text-gold-400 text-sm">{{ $ownerTitle }}</p>
            @if($ownerQualification)
                <p class="text-white/50 text-xs mt-0.5">
                    <i class="fa-solid fa-graduation-cap mr-1"></i>{{ $ownerQualification }}
                </p>
            @endif
            <p class="text-white/40 text-xs mt-0.5">WinTech Institute</p>
        </div>
    </div>

    {{-- Contact Links --}}
    <div class="space-y-3">
        @if($ownerPhone)
        <a href="tel:{{ preg_replace('/\s+/', '', $ownerPhone) }}"
           class="flex items-center gap-3 text-white/70 hover:text-white transition-colors text-sm">
            <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center shrink-0">
                <i class="fa-solid fa-phone text-gold-400 text-xs"></i>
            </div>
            {{ $ownerPhone }}
        </a>
        @endif

        @if($ownerWhatsapp)
        <a href="https://wa.me/{{ $ownerWhatsapp }}" target="_blank"
           class="flex items-center gap-3 text-white/70 hover:text-white transition-colors text-sm">
            <div class="w-8 h-8 bg-green-500/20 rounded-lg flex items-center justify-center shrink-0">
                <i class="fa-brands fa-whatsapp text-green-400 text-xs"></i>
            </div>
            Chat on WhatsApp
        </a>
        @endif

        @if($ownerAddress)
        <div class="flex items-center gap-3 text-white/50 text-sm">
            <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center shrink-0">
                <i class="fa-solid fa-location-dot text-gold-400 text-xs"></i>
            </div>
            {{ $ownerAddress }}
        </div>
        @endif
    </div>
</div>
            </div>
        </div>
    </div>
</section>

@endsection