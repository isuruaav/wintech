<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'WinTech Institute') — WinTech</title>
    <meta name="description" content="@yield('meta_description', 'WinTech Institute of Information Technology — Empowering Minds Through Technology')">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* WhatsApp Float - LEFT */
        .whatsapp-float {
            position: fixed;
            bottom: 20px;
            left: 20px;
            background: #25D366;
            color: #fff;
            width: 55px;
            height: 55px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
            z-index: 998;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        .whatsapp-float:hover {
            transform: scale(1.1);
            box-shadow: 0 10px 30px rgba(0,0,0,0.4);
        }

        /* Scroll Top - RIGHT */
        .scroll-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: linear-gradient(135deg, #f0a400, #fbd96a);
            color: #000;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
            z-index: 998;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        .scroll-top:hover {
            transform: translateY(-5px) scale(1.1);
        }

        /* Ticker */
        .ticker-wrap { overflow: hidden; }
        .animate-ticker { animation: tickerMove 35s linear infinite; }
        @keyframes tickerMove {
            0%   { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        /* Popup */
        .animate-popup {
            animation: popupIn .35s cubic-bezier(.34,1.56,.64,1) forwards;
        }
        @keyframes popupIn {
            from { opacity: 0; transform: scale(.88) translateY(20px); }
            to   { opacity: 1; transform: scale(1)   translateY(0); }
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

{{-- Precompute announcements once --}}
@php
    $activeAnnouncements = \App\Models\Announcement::active()->latest()->get();
    $tickerItems         = $activeAnnouncements->whereNotIn('type', ['urgent']);
    $popupItems          = $activeAnnouncements->where('type', 'urgent');
    $generalPopup        = $activeAnnouncements->whereNotIn('type', ['urgent'])->first();
@endphp

{{-- PRELOADER --}}
<div id="preloader">
    <div class="text-center">
        <div class="loader-ring mx-auto mb-4"></div>
        <p class="text-gold-400 font-bold tracking-widest text-sm">WINTECH</p>
    </div>
</div>

{{-- NAVBAR (fixed top-0) --}}
<nav id="navbar" class="fixed top-0 left-0 right-0 z-50 bg-navy-900/95 backdrop-blur-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}"
                     alt="WinTech Logo"
                     class="w-10 h-10 object-contain">
                <div>
                    <p class="text-white font-extrabold text-base leading-none">WinTech</p>
                    <p class="text-gold-400 text-xs leading-none">Institute</p>
                </div>
            </a>

            {{-- Desktop Nav --}}
            <div class="hidden lg:flex items-center gap-1">
                <a href="{{ route('home') }}"                 class="nav-link px-3 py-2 rounded-lg hover:bg-white/10">Home</a>
                <a href="{{ route('grade.index') }}"          class="nav-link px-3 py-2 rounded-lg hover:bg-white/10">Grade Classes</a>
                <a href="{{ route('online-classes.index') }}" class="nav-link px-3 py-2 rounded-lg hover:bg-white/10">Online Classes</a>
                <a href="{{ route('courses.index') }}"        class="nav-link px-3 py-2 rounded-lg hover:bg-white/10">Courses</a>
                <a href="{{ route('videos.index') }}"         class="nav-link px-3 py-2 rounded-lg hover:bg-white/10">Videos</a>
                <a href="{{ route('gallery.index') }}"        class="nav-link px-3 py-2 rounded-lg hover:bg-white/10">Gallery</a>
                <a href="{{ route('papers.index') }}"         class="nav-link px-3 py-2 rounded-lg hover:bg-white/10">Papers</a>
                <a href="{{ route('downloads.index') }}"      class="nav-link px-3 py-2 rounded-lg hover:bg-white/10">Downloads</a>
                <a href="{{ route('contact') }}"              class="nav-link px-3 py-2 rounded-lg hover:bg-white/10">Contact</a>
            </div>

            {{-- Right Actions --}}
            <div class="flex items-center gap-2">
                <button id="search-btn" class="w-9 h-9 rounded-lg bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-colors">
                    <i class="fa-solid fa-magnifying-glass text-sm"></i>
                </button>
                @auth
                    @if(Auth::user()->isStudent())
                        <a href="{{ route('results.index') }}"
                           class="nav-link px-3 py-2 rounded-lg hover:bg-white/10 flex items-center gap-1.5 text-yellow-400 hover:text-yellow-300">
                            <i class="fa-solid fa-file-circle-check text-sm"></i>
                            <span class="hidden sm:inline">My Results</span>
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button class="nav-link px-3 py-2 text-xs">Logout</button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn-gold py-2 px-4 text-xs hidden sm:inline-flex">Student Login</a>
                @endauth
                <button id="menu-btn" class="lg:hidden w-9 h-9 rounded-lg bg-white/10 text-white flex items-center justify-center">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div id="mobile-menu" class="lg:hidden bg-navy-950 border-t border-white/10">
        <div class="px-4 py-3 space-y-1">
            <a href="{{ route('home') }}"                 class="nav-link block px-3 py-2.5 rounded-lg hover:bg-white/10">Home</a>
            <a href="{{ route('grade.index') }}"          class="nav-link block px-3 py-2.5 rounded-lg hover:bg-white/10">Grade Classes</a>
            <a href="{{ route('online-classes.index') }}" class="nav-link block px-3 py-2.5 rounded-lg hover:bg-white/10">Online Classes</a>
            <a href="{{ route('courses.index') }}"        class="nav-link block px-3 py-2.5 rounded-lg hover:bg-white/10">Courses</a>
            <a href="{{ route('videos.index') }}"         class="nav-link block px-3 py-2.5 rounded-lg hover:bg-white/10">Videos</a>
            <a href="{{ route('gallery.index') }}"        class="nav-link block px-3 py-2.5 rounded-lg hover:bg-white/10">Gallery</a>
            <a href="{{ route('papers.index') }}"         class="nav-link block px-3 py-2.5 rounded-lg hover:bg-white/10">Papers</a>
            <a href="{{ route('downloads.index') }}"      class="nav-link block px-3 py-2.5 rounded-lg hover:bg-white/10">Downloads</a>
            <a href="{{ route('contact') }}"              class="nav-link block px-3 py-2.5 rounded-lg hover:bg-white/10">Contact</a>
            @auth
                @if(Auth::user()->isStudent())
                    <a href="{{ route('results.index') }}"
                       class="nav-link block px-3 py-2.5 rounded-lg hover:bg-white/10 text-yellow-400">
                        <i class="fa-solid fa-file-circle-check mr-1"></i> My Results
                    </a>
                @endif
            @endauth
            @guest
                <a href="{{ route('login') }}" class="btn-gold w-full justify-center mt-2">Student Login</a>
            @endguest
        </div>
    </div>
</nav>

{{-- SEARCH OVERLAY --}}
<div id="search-panel" class="hidden fixed inset-0 bg-navy-950/95 z-[200] flex items-start justify-center pt-24 px-4">
    <div class="w-full max-w-2xl">
        <form action="{{ route('search') }}" method="GET">
            <div class="flex gap-3">
                <input type="text" name="q" placeholder="Search courses, classes..."
                       class="flex-1 bg-white/10 border border-white/20 text-white placeholder-white/40 rounded-xl px-5 py-4 text-lg outline-none focus:border-gold-500">
                <button type="submit" class="btn-gold px-6 py-4 rounded-xl text-base">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>
        </form>
        <button id="search-close" class="mt-4 text-white/50 hover:text-white text-sm flex items-center gap-2 mx-auto">
            <i class="fa-solid fa-xmark"></i> Close
        </button>
    </div>
</div>

{{-- FLASH MESSAGES --}}
@if(session('success'))
<div class="flash-msg fixed top-20 right-4 z-[150] bg-green-500 text-white px-5 py-3 rounded-xl shadow-lg flex items-center gap-3 transition-opacity">
    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="flash-msg fixed top-20 right-4 z-[150] bg-red-500 text-white px-5 py-3 rounded-xl shadow-lg flex items-center gap-3 transition-opacity">
    <i class="fa-solid fa-circle-xmark"></i> {{ session('error') }}
</div>
@endif

{{-- MAIN CONTENT — pt-16 for fixed navbar --}}
<main class="pt-16">

    {{-- TICKER — inside main, sits directly below navbar --}}
    @if($tickerItems->count())
    <div id="ann-ticker" class="bg-navy-900 text-white text-sm py-2.5 ticker-wrap">
        <div class="flex items-center">
            <span class="shrink-0 bg-gold-500 text-navy-900 font-bold text-xs px-3 py-1 mr-4">
                <i class="fa-solid fa-bullhorn mr-1"></i> NOTICE
            </span>
            <div class="flex-1 overflow-hidden">
                <div class="flex gap-16 whitespace-nowrap animate-ticker">
                    @foreach($tickerItems as $item)
                        <span class="inline-flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full shrink-0
                                {{ $item->type === 'exam'     ? 'bg-blue-400'   :
                                   ($item->type === 'event'   ? 'bg-purple-400' :
                                   ($item->type === 'holiday' ? 'bg-green-400'  : 'bg-gold-400')) }}">
                            </span>
                            <strong>{{ $item->title }}</strong> — {{ Str::limit($item->content, 80) }}
                        </span>
                    @endforeach
                    {{-- Duplicate for seamless loop --}}
                    @foreach($tickerItems as $item)
                        <span class="inline-flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full shrink-0
                                {{ $item->type === 'exam'     ? 'bg-blue-400'   :
                                   ($item->type === 'event'   ? 'bg-purple-400' :
                                   ($item->type === 'holiday' ? 'bg-green-400'  : 'bg-gold-400')) }}">
                            </span>
                            <strong>{{ $item->title }}</strong> — {{ Str::limit($item->content, 80) }}
                        </span>
                    @endforeach
                </div>
            </div>
            <button onclick="document.getElementById('ann-ticker').style.display='none'"
                    class="shrink-0 ml-3 text-white/50 hover:text-white px-3 text-lg leading-none">
                &times;
            </button>
        </div>
    </div>
    @endif

    @yield('content')
</main>

{{-- FOOTER --}}
<footer class="bg-navy-950 text-white mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-10 mb-10">

            <div>
                <div class="flex items-center gap-3 mb-4">
                    <img src="{{ asset('images/logo.png') }}"
                         alt="WinTech Logo"
                         class="w-10 h-10 object-contain">
                    <div>
                        <p class="font-extrabold text-base leading-none">WinTech</p>
                        <p class="text-gold-400 text-xs">Institute</p>
                    </div>
                </div>
                <p class="text-white/50 text-sm leading-relaxed">Empowering Minds Through Technology. Quality IT education for all.</p>
                <div class="flex gap-3 mt-4">
                    <a href="https://facebook.com/wintechinstitute" target="_blank"
                       class="w-8 h-8 bg-white/10 hover:bg-gold-500 rounded-lg flex items-center justify-center transition-colors">
                        <i class="fa-brands fa-facebook-f text-sm"></i>
                    </a>
                    <a href="https://wa.me/94784161920" target="_blank"
                       class="w-8 h-8 bg-white/10 hover:bg-green-500 rounded-lg flex items-center justify-center transition-colors">
                        <i class="fa-brands fa-whatsapp text-sm"></i>
                    </a>
                </div>
            </div>

            <div>
                <h4 class="font-bold text-sm uppercase tracking-wider text-gold-400 mb-4">Quick Links</h4>
                <ul class="space-y-2 text-sm text-white/60">
                    <li><a href="{{ route('courses.index') }}"        class="hover:text-gold-400 transition-colors">Courses</a></li>
                    <li><a href="{{ route('grade.index') }}"          class="hover:text-gold-400 transition-colors">Grade Classes</a></li>
                    <li><a href="{{ route('online-classes.index') }}" class="hover:text-gold-400 transition-colors">Online Classes</a></li>
                    <li><a href="{{ route('gallery.index') }}"        class="hover:text-gold-400 transition-colors">Gallery</a></li>
                    <li><a href="{{ route('papers.index') }}"         class="hover:text-gold-400 transition-colors">Past Papers</a></li>
                    <li><a href="{{ route('downloads.index') }}"      class="hover:text-gold-400 transition-colors">Downloads</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-sm uppercase tracking-wider text-gold-400 mb-4">Courses</h4>
                <ul class="space-y-2 text-sm text-white/60">
                    <li><a href="{{ route('courses.index') }}" class="hover:text-gold-400 transition-colors">Office Applications</a></li>
                    <li><a href="{{ route('courses.index') }}" class="hover:text-gold-400 transition-colors">Web Development</a></li>
                    <li><a href="{{ route('courses.index') }}" class="hover:text-gold-400 transition-colors">Cyber Security</a></li>
                    <li><a href="{{ route('courses.index') }}" class="hover:text-gold-400 transition-colors">Robo Technology</a></li>
                    <li><a href="{{ route('courses.index') }}" class="hover:text-gold-400 transition-colors">CCTV Installation</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-sm uppercase tracking-wider text-gold-400 mb-4">Contact</h4>
                <ul class="space-y-3 text-sm text-white/60">
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-location-dot text-gold-400 mt-0.5"></i>
                        <span>Kiralabokkagama,<br>Moragollagama</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fa-solid fa-phone text-gold-400"></i>
                        <a href="tel:+94784161920" class="hover:text-gold-400">+94 78 416 1920</a>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fa-solid fa-envelope text-gold-400"></i>
                        <a href="mailto:info@wintech.lk" class="hover:text-gold-400">info@wintech.lk</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-white/10 pt-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-sm text-white/40">
            <p>&copy; {{ date('Y') }} ISD Tech Hub (Pvt) Ltd. All rights reserved.</p>
        </div>
    </div>
</footer>

{{-- WHATSAPP FLOAT (LEFT) --}}
<a href="https://wa.me/94784161920" target="_blank" class="whatsapp-float">
    <i class="fa-brands fa-whatsapp"></i>
</a>

{{-- SCROLL TO TOP (RIGHT) --}}
<button id="scrollTopBtn" class="scroll-top">
    <i class="fa-solid fa-arrow-up"></i>
</button>

{{-- LIGHTBOX --}}
<div id="lightbox">
    <button id="lb-close" class="absolute top-4 right-4 text-white text-2xl w-10 h-10 flex items-center justify-center hover:text-gold-400">
        <i class="fa-solid fa-xmark"></i>
    </button>
    <button id="lb-prev" class="absolute left-4 text-white text-2xl w-10 h-10 flex items-center justify-center hover:text-gold-400">
        <i class="fa-solid fa-chevron-left"></i>
    </button>
    <img id="lb-img" src="" alt="Gallery Image" class="rounded-xl">
    <button id="lb-next" class="absolute right-4 text-white text-2xl w-10 h-10 flex items-center justify-center hover:text-gold-400">
        <i class="fa-solid fa-chevron-right"></i>
    </button>
</div>

{{-- ==============================================
     ANNOUNCEMENT POPUP
     Placed last so it renders above everything
     ============================================== --}}
@if($popupItems->count() || $generalPopup)
@php $popupAnn = $popupItems->first() ?? $generalPopup; @endphp
<div id="ann-popup"
     style="position:fixed;inset:0;z-index:99999;display:none;align-items:center;justify-content:center;padding:1rem;background:rgba(0,0,0,0.7);backdrop-filter:blur(6px);">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden animate-popup">

        {{-- Coloured header --}}
        <div class="px-6 py-4 flex items-center justify-between
            {{ $popupAnn->type === 'urgent'  ? 'bg-red-500'    :
               ($popupAnn->type === 'exam'   ? 'bg-blue-600'   :
               ($popupAnn->type === 'event'  ? 'bg-purple-600' :
               ($popupAnn->type === 'holiday'? 'bg-green-600'  : 'bg-navy-900'))) }}">
            <div class="flex items-center gap-2 text-white">
                <i class="fa-solid
                    {{ $popupAnn->type === 'urgent'  ? 'fa-triangle-exclamation' :
                       ($popupAnn->type === 'exam'   ? 'fa-file-circle-check'    :
                       ($popupAnn->type === 'event'  ? 'fa-calendar-star'        :
                       ($popupAnn->type === 'holiday'? 'fa-umbrella-beach'       : 'fa-bullhorn'))) }}">
                </i>
                <span class="font-bold uppercase text-sm tracking-wide">
                    {{ ucfirst($popupAnn->type ?? 'Notice') }}
                </span>
            </div>
            <button onclick="closeAnnPopup()" class="text-white/70 hover:text-white">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        {{-- Optional image --}}
        @if($popupAnn->image)
        <img src="{{ Storage::url($popupAnn->image) }}"
             alt="{{ $popupAnn->title }}"
             class="w-full h-48 object-cover">
        @endif

        {{-- Body --}}
        <div class="px-6 py-5">
            <h3 class="text-xl font-extrabold text-slate-800 mb-2">{{ $popupAnn->title }}</h3>
            <p class="text-slate-600 text-sm leading-relaxed">{{ $popupAnn->content }}</p>
            @if($popupAnn->end_date)
            <p class="mt-3 text-xs text-slate-400 flex items-center gap-1.5">
                <i class="fa-solid fa-clock"></i>
                Valid until: {{ $popupAnn->end_date->format('d M Y') }}
            </p>
            @endif
        </div>

        {{-- Footer --}}
        <div class="px-6 pb-5 flex items-center justify-between">
            <label class="flex items-center gap-2 text-sm text-slate-500 cursor-pointer select-none">
                <input type="checkbox" id="ann-dont-show" class="rounded accent-navy-900">
                Don't show again today
            </label>
            <button onclick="closeAnnPopup()"
                    class="bg-navy-900 hover:bg-navy-800 text-white text-sm font-semibold px-5 py-2 rounded-xl transition-colors">
                Got it
            </button>
        </div>
    </div>
</div>

<script>
(function () {
    var popup      = document.getElementById('ann-popup');
    var storageKey = 'wt_ann_{{ $popupAnn->id }}_{{ $popupAnn->updated_at?->timestamp ?? 0 }}';
    var stored     = localStorage.getItem(storageKey);

    if (!stored || Date.now() > parseInt(stored, 10)) {
        setTimeout(function () { popup.style.display = 'flex'; }, 800);
    }

    window.closeAnnPopup = function () {
        var cb = document.getElementById('ann-dont-show');
        if (cb && cb.checked) {
            var midnight = new Date();
            midnight.setHours(23, 59, 59, 999);
            localStorage.setItem(storageKey, midnight.getTime());
        }
        popup.style.display = 'none';
    };

    popup.addEventListener('click', function (e) {
        if (e.target === popup) closeAnnPopup();
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeAnnPopup();
    });
}());
</script>
@endif
{{-- ===== END POPUP ===== --}}

<script>
    var scrollBtn = document.getElementById('scrollTopBtn');
    window.addEventListener('scroll', function () {
        scrollBtn.style.display = window.scrollY > 200 ? 'flex' : 'none';
    });
    scrollBtn.addEventListener('click', function () {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
</script>
{{-- ===== AI CHATBOT WIDGET ===== --}}
<style>
#chat-btn {
    position: fixed; bottom: 88px; right: 20px;
    width: 54px; height: 54px; border-radius: 50%;
    background: linear-gradient(135deg, #1e3a5f, #2d5f8a);
    color: #fff; border: none; cursor: pointer;
    box-shadow: 0 6px 20px rgba(0,0,0,0.3);
    z-index: 997; font-size: 22px;
    display: flex; align-items: center; justify-content: center;
    transition: all .3s ease;
}
#chat-btn:hover { transform: scale(1.1); }
#chat-btn .chat-badge {
    position: absolute; top: -4px; right: -4px;
    width: 18px; height: 18px; border-radius: 50%;
    background: #f0a400; font-size: 10px; font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    color: #000;
}
#chat-window {
    position: fixed; bottom: 155px; right: 20px;
    width: 340px; height: 480px; border-radius: 20px;
    background: #fff; box-shadow: 0 20px 60px rgba(0,0,0,0.2);
    z-index: 996; display: none; flex-direction: column;
    overflow: hidden; border: 1px solid rgba(0,0,0,0.08);
    font-family: inherit;
}
#chat-header {
    background: linear-gradient(135deg, #1e3a5f, #2d5f8a);
    padding: 14px 16px; display: flex; align-items: center; gap-10px;
    gap: 10px; flex-shrink: 0;
}
#chat-header img { width: 36px; height: 36px; border-radius: 50%; object-fit: cover; border: 2px solid rgba(255,255,255,0.3); }
#chat-header .avatar-placeholder {
    width: 36px; height: 36px; border-radius: 50%;
    background: #f0a400; display: flex; align-items: center; justify-content: center;
    font-size: 16px; color: #1e3a5f; font-weight: 700; flex-shrink: 0;
}
#chat-header .info { flex: 1; }
#chat-header .info p { color: #fff; font-weight: 700; font-size: 14px; margin: 0; }
#chat-header .info span { color: rgba(255,255,255,0.6); font-size: 11px; }
#chat-header .online-dot {
    width: 8px; height: 8px; border-radius: 50%; background: #4ade80;
    box-shadow: 0 0 0 2px rgba(74,222,128,0.3);
}
#chat-close { background: none; border: none; color: rgba(255,255,255,0.7); cursor: pointer; font-size: 18px; padding: 0; }
#chat-close:hover { color: #fff; }
#chat-messages {
    flex: 1; overflow-y: auto; padding: 16px 12px;
    display: flex; flex-direction: column; gap: 10px;
    background: #f8fafc;
}
#chat-messages::-webkit-scrollbar { width: 4px; }
#chat-messages::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 4px; }
.chat-msg { display: flex; gap: 8px; align-items: flex-end; max-width: 100%; }
.chat-msg.bot { justify-content: flex-start; }
.chat-msg.user { justify-content: flex-end; }
.chat-msg .avatar {
    width: 28px; height: 28px; border-radius: 50%; background: #1e3a5f;
    display: flex; align-items: center; justify-content: center;
    font-size: 13px; color: #f0a400; flex-shrink: 0;
}
.chat-bubble {
    max-width: 75%; padding: 9px 13px; border-radius: 16px;
    font-size: 13px; line-height: 1.5;
}
.bot .chat-bubble {
    background: #fff; color: #334155;
    border-bottom-left-radius: 4px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.08);
}
.user .chat-bubble {
    background: linear-gradient(135deg, #1e3a5f, #2d5f8a);
    color: #fff; border-bottom-right-radius: 4px;
}
.chat-bubble a { color: #f0a400; text-decoration: underline; }
.typing-dots { display: flex; gap: 4px; padding: 4px 2px; }
.typing-dots span {
    width: 7px; height: 7px; background: #94a3b8; border-radius: 50%;
    animation: dot-bounce .9s infinite;
}
.typing-dots span:nth-child(2) { animation-delay: .2s; }
.typing-dots span:nth-child(3) { animation-delay: .4s; }
@keyframes dot-bounce {
    0%,60%,100% { transform: translateY(0); }
    30% { transform: translateY(-6px); }
}
#chat-quick { padding: 8px 12px; display: flex; flex-wrap: wrap; gap: 6px; background: #fff; border-top: 1px solid #f1f5f9; flex-shrink: 0; }
.quick-btn {
    background: #f1f5f9; border: none; border-radius: 20px;
    padding: 5px 12px; font-size: 11px; cursor: pointer; color: #475569;
    transition: all .2s; white-space: nowrap;
}
.quick-btn:hover { background: #1e3a5f; color: #fff; }
#chat-form { padding: 10px 12px; display: flex; gap: 8px; background: #fff; border-top: 1px solid #f1f5f9; flex-shrink: 0; }
#chat-input {
    flex: 1; border: 1px solid #e2e8f0; border-radius: 20px;
    padding: 8px 14px; font-size: 13px; outline: none;
    transition: border-color .2s; font-family: inherit;
}
#chat-input:focus { border-color: #1e3a5f; }
#chat-send {
    width: 36px; height: 36px; border-radius: 50%;
    background: #1e3a5f; color: #fff; border: none; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    font-size: 14px; transition: background .2s; flex-shrink: 0;
}
#chat-send:hover { background: #f0a400; color: #1e3a5f; }
</style>

{{-- Chat Button --}}
<button id="chat-btn" onclick="toggleChat()" title="Chat with WinTech">
    <i class="fa-solid fa-comments" id="chat-icon"></i>
    <span class="chat-badge">?</span>
</button>

{{-- Chat Window --}}
<div id="chat-window">
    <div id="chat-header">
        <div class="avatar-placeholder">W</div>
        <div class="info">
            <p>WinTech Assistant</p>
            <span>Institute information bot</span>
        </div>
        <div class="online-dot"></div>
        <button id="chat-close" onclick="toggleChat()"><i class="fa-solid fa-xmark"></i></button>
    </div>

    <div id="chat-messages"></div>

    <div id="chat-quick">
        <button class="quick-btn" onclick="sendQuick('Courses')">📚 Courses</button>
        <button class="quick-btn" onclick="sendQuick('Grade Classes')">🏫 Grade Classes</button>
        <button class="quick-btn" onclick="sendQuick('Fees')">💰 Fees</button>
        <button class="quick-btn" onclick="sendQuick('Contact')">📞 Contact</button>
        <button class="quick-btn" onclick="sendQuick('Location')">📍 Location</button>
        <button class="quick-btn" onclick="sendQuick('Online Classes')">💻 Online</button>
    </div>

    <form id="chat-form" onsubmit="sendMessage(event)">
        <input type="text" id="chat-input" placeholder="Type your question..." autocomplete="off">
        <button type="submit" id="chat-send"><i class="fa-solid fa-paper-plane"></i></button>
    </form>
</div>

<script>
(function () {

// ===================== KNOWLEDGE BASE =====================
var KB = [
    {
        keys: ['course','courses','what courses','available','offer','program'],
        answer: '📚 <strong>WinTech Institute</strong> offers the following courses:<br><br>• Office Applications (MS Word, Excel, PowerPoint)<br>• Web Development (HTML, CSS, PHP, Laravel)<br>• Cyber Security<br>• Robo Technology<br>• CCTV Installation<br><br><a href="/courses">View all courses →</a>'
    },
    {
        keys: ['grade','grade class','classes','school','grade 6','grade 7','grade 8','grade 9','grade 10','grade 11','ol','al'],
        answer: '🏫 We offer <strong>Grade Classes</strong> for students from Grade 6 to A/L level, covering ICT and other subjects.<br><br><a href="/grade-classes">View grade classes →</a>'
    },
    {
        keys: ['online','online class','zoom','live','virtual'],
        answer: '💻 Yes! WinTech offers <strong>Online Classes</strong> via live sessions. Students can join from home.<br><br><a href="/online-classes">View online classes →</a>'
    },
    {
        keys: ['fee','fees','cost','price','charge','payment','how much'],
        answer: '💰 Course fees vary by program. Please <strong>contact us</strong> directly for the latest fee details.<br><br>📞 <a href="tel:+94784161920">+94 78 416 1920</a><br>💬 <a href="https://wa.me/94784161920" target="_blank">WhatsApp us</a>'
    },
    {
        keys: ['contact','phone','call','reach','whatsapp','message'],
        answer: '📞 <strong>Contact WinTech:</strong><br><br>• Phone: <a href="tel:+94784161920">+94 78 416 1920</a><br>• WhatsApp: <a href="https://wa.me/94784161920" target="_blank">Chat now</a><br>• Email: <a href="mailto:info@wintech.lk">info@wintech.lk</a><br><br><a href="/contact">Contact page →</a>'
    },
    {
        keys: ['location','address','where','place','find','kiralabokkagama','moragollagama','directions'],
        answer: '📍 <strong>WinTech Institute</strong> is located at:<br><br>Kiralabokkagama, Moragollagama<br><br>Contact us for exact directions: <a href="tel:+94784161920">+94 78 416 1920</a>'
    },
    {
        keys: ['register','enroll','admission','join','sign up','apply'],
        answer: '✅ To <strong>enroll</strong> at WinTech:<br><br>1. Contact us via phone or WhatsApp<br>2. Visit the institute directly<br><br>📞 <a href="tel:+94784161920">+94 78 416 1920</a><br>💬 <a href="https://wa.me/94784161920" target="_blank">WhatsApp us</a>'
    },
    {
        keys: ['result','results','marks','exam','test'],
        answer: '📊 Students can view their <strong>exam results</strong> by logging into the student portal.<br><br><a href="/login">Student Login →</a>'
    },
    {
        keys: ['certificate','certificat','certif'],
        answer: '🎓 WinTech Institute provides <strong>certificates</strong> upon successful completion of courses. Contact us for more details.<br><br>📞 <a href="tel:+94784161920">+94 78 416 1920</a>'
    },
    {
        keys: ['gallery','photo','image','picture','event'],
        answer: '🖼️ Check out our <strong>gallery</strong> to see institute activities and events!<br><br><a href="/gallery">View Gallery →</a>'
    },
    {
        keys: ['video','videos','youtube','watch'],
        answer: '🎥 Watch our educational <strong>videos</strong> and tutorials.<br><br><a href="/videos">View Videos →</a>'
    },
    {
        keys: ['paper','papers','past','past paper','past papers','download'],
        answer: '📄 We provide <strong>past papers</strong> and study materials for download.<br><br><a href="/past-papers">Past Papers →</a><br><a href="/downloads">Downloads →</a>'
    },
    {
        keys: ['hello','hi','hey','good morning','good afternoon','good evening','ayubowan'],
        answer: '👋 Hello! Welcome to <strong>WinTech Institute</strong>! I\'m here to help you.<br><br>Ask me about our courses, fees, location, or anything else! 😊'
    },
    {
        keys: ['thank','thanks','thank you','thx'],
        answer: '😊 You\'re welcome! Feel free to ask anything else. We\'re happy to help! <br><br>📞 <a href="tel:+94784161920">Call us anytime</a>'
    },
    {
        keys: ['owner','director','founder','who','chathuranga','teacher'],
        answer: '👨‍💼 <strong>WinTech Institute</strong> was founded by <strong>Chathuranga Dissanayaka</strong>, Founder & Director.<br><br>📞 <a href="tel:+94784161920">+94 78 416 1920</a>'
    },
    {
        keys: ['time','timing','open','hours','working','schedule'],
        answer: '🕐 For our <strong>class schedules</strong> and working hours, please contact us directly.<br><br>📞 <a href="tel:+94784161920">+94 78 416 1920</a><br>💬 <a href="https://wa.me/94784161920" target="_blank">WhatsApp us</a>'
    },
];

var chatOpen  = false;
var welcomed  = false;
var msgBox    = null;

window.toggleChat = function () {
    var win = document.getElementById('chat-window');
    var ico = document.getElementById('chat-icon');
    chatOpen = !chatOpen;
    win.style.display = chatOpen ? 'flex' : 'none';
    ico.className = chatOpen ? 'fa-solid fa-xmark' : 'fa-solid fa-comments';
    document.querySelector('.chat-badge').style.display = chatOpen ? 'none' : 'flex';
    if (chatOpen && !welcomed) {
        welcomed = true;
        setTimeout(function () {
            showTyping(function () {
                addBotMsg('👋 <strong>Hello! Welcome to WinTech Institute!</strong><br><br>I can help you with information about our courses, fees, location, and more. How can I assist you today?');
            });
        }, 400);
    }
    if (chatOpen) {
        setTimeout(function () { document.getElementById('chat-input').focus(); }, 300);
    }
};

window.sendQuick = function (text) {
    processUserInput(text);
};

window.sendMessage = function (e) {
    e.preventDefault();
    var input = document.getElementById('chat-input');
    var text  = input.value.trim();
    if (!text) return;
    input.value = '';
    processUserInput(text);
};

function processUserInput(text) {
    addUserMsg(text);
    var lower   = text.toLowerCase();
    var matched = null;
    var bestScore = 0;

    KB.forEach(function (item) {
        var score = 0;
        item.keys.forEach(function (k) {
            if (lower.includes(k)) score += k.length;
        });
        if (score > bestScore) { bestScore = score; matched = item; }
    });

    setTimeout(function () {
        showTyping(function () {
            if (matched && bestScore > 0) {
                addBotMsg(matched.answer);
            } else {
                addBotMsg('🤔 I\'m not sure about that. Let me connect you with our team!<br><br>📞 <a href="tel:+94784161920">+94 78 416 1920</a><br>💬 <a href="https://wa.me/94784161920" target="_blank">WhatsApp us</a><br><br>Or ask about: <em>courses, fees, location, contact, online classes</em>');
            }
        });
    }, 500);
}

function addUserMsg(text) {
    getBox().insertAdjacentHTML('beforeend',
        '<div class="chat-msg user"><div class="chat-bubble">' + escHtml(text) + '</div></div>'
    );
    scrollBottom();
}

function addBotMsg(html) {
    getBox().insertAdjacentHTML('beforeend',
        '<div class="chat-msg bot"><div class="avatar"><i class="fa-solid fa-robot"></i></div><div class="chat-bubble">' + html + '</div></div>'
    );
    scrollBottom();
}

function showTyping(cb) {
    var id  = 'typing-' + Date.now();
    var box = getBox();
    box.insertAdjacentHTML('beforeend',
        '<div class="chat-msg bot" id="' + id + '"><div class="avatar"><i class="fa-solid fa-robot"></i></div><div class="chat-bubble"><div class="typing-dots"><span></span><span></span><span></span></div></div></div>'
    );
    scrollBottom();
    setTimeout(function () {
        var el = document.getElementById(id);
        if (el) el.remove();
        cb();
    }, 900);
}

function getBox() {
    if (!msgBox) msgBox = document.getElementById('chat-messages');
    return msgBox;
}

function scrollBottom() {
    var b = getBox();
    b.scrollTop = b.scrollHeight;
}

function escHtml(t) {
    return t.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}

}());
</script>
{{-- ===== END CHATBOT ===== --}}
</body>
</html>