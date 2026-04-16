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
/* WhatsApp - LEFT */
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
    z-index: 999;
    transition: all 0.3s ease;
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
    z-index: 999;
    transition: all 0.3s ease;
    border: none;
}

.scroll-top:hover {
    transform: translateY(-5px) scale(1.1);
}
</style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

{{-- PRELOADER --}}
<div id="preloader">
    <div class="text-center">
        <div class="loader-ring mx-auto mb-4"></div>
        <p class="text-gold-400 font-bold tracking-widest text-sm">WINTECH</p>
    </div>
</div>

{{-- NAVBAR --}}
<nav id="navbar" class="fixed top-0 left-0 right-0 z-50 bg-navy-900/95 backdrop-blur-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

        <a href="{{ route('home') }}" class="flex items-center gap-3">

    <!-- Logo Image -->
    <img src="{{ asset('images/logo.png') }}" 
         alt="WinTech Logo" 
         class="w-10 h-10 object-contain">

    <!-- Text -->
    <div>
        <p class="text-white font-extrabold text-base leading-none">WinTech</p>
        <p class="text-gold-400 text-xs leading-none">Institute</p>
    </div>

</a>

            {{-- Desktop Nav --}}
            <div class="hidden lg:flex items-center gap-1">
                <a href="{{ route('home') }}"              class="nav-link px-3 py-2 rounded-lg hover:bg-white/10">Home</a>
                <a href="{{ route('grade.index') }}"       class="nav-link px-3 py-2 rounded-lg hover:bg-white/10">Grade Classes</a>
                <a href="{{ route('online-classes.index') }}" class="nav-link px-3 py-2 rounded-lg hover:bg-white/10">Online Classes</a>
                <a href="{{ route('courses.index') }}"     class="nav-link px-3 py-2 rounded-lg hover:bg-white/10">Courses</a>
                <a href="{{ route('videos.index') }}"      class="nav-link px-3 py-2 rounded-lg hover:bg-white/10">Videos</a>
                <a href="{{ route('gallery.index') }}"     class="nav-link px-3 py-2 rounded-lg hover:bg-white/10">Gallery</a>
                <a href="{{ route('papers.index') }}"      class="nav-link px-3 py-2 rounded-lg hover:bg-white/10">Papers</a>
                <a href="{{ route('contact') }}"           class="nav-link px-3 py-2 rounded-lg hover:bg-white/10">Contact</a>
            </div>

            {{-- Right Actions --}}
            <div class="flex items-center gap-2">
                <button id="search-btn" class="w-9 h-9 rounded-lg bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-colors">
                    <i class="fa-solid fa-magnifying-glass text-sm"></i>
                </button>
                @auth
                    @if(Auth::user()->isStudent())
                        <a href="{{ route('student.results') }}" class="btn-gold py-2 px-4 text-xs">My Results</a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">@csrf
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
            <a href="{{ route('home') }}"              class="nav-link block px-3 py-2.5 rounded-lg hover:bg-white/10">Home</a>
            <a href="{{ route('grade.index') }}"       class="nav-link block px-3 py-2.5 rounded-lg hover:bg-white/10">Grade Classes</a>
            <a href="{{ route('online-classes.index') }}" class="nav-link block px-3 py-2.5 rounded-lg hover:bg-white/10">Online Classes</a>
            <a href="{{ route('courses.index') }}"     class="nav-link block px-3 py-2.5 rounded-lg hover:bg-white/10">Courses</a>
            <a href="{{ route('videos.index') }}"      class="nav-link block px-3 py-2.5 rounded-lg hover:bg-white/10">Videos</a>
            <a href="{{ route('gallery.index') }}"     class="nav-link block px-3 py-2.5 rounded-lg hover:bg-white/10">Gallery</a>
            <a href="{{ route('papers.index') }}"      class="nav-link block px-3 py-2.5 rounded-lg hover:bg-white/10">Papers</a>
            <a href="{{ route('contact') }}"           class="nav-link block px-3 py-2.5 rounded-lg hover:bg-white/10">Contact</a>
            @guest
            <a href="{{ route('login') }}" class="btn-gold w-full justify-center mt-2">Student Login</a>
            @endguest
        </div>
    </div>
</nav>

{{-- SEARCH OVERLAY --}}
<div id="search-panel" class="hidden fixed inset-0 bg-navy-950/95 z-50 flex items-start justify-center pt-24 px-4">
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
<div class="flash-msg fixed top-20 right-4 z-50 bg-green-500 text-white px-5 py-3 rounded-xl shadow-lg flex items-center gap-3 transition-opacity">
    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="flash-msg fixed top-20 right-4 z-50 bg-red-500 text-white px-5 py-3 rounded-xl shadow-lg flex items-center gap-3 transition-opacity">
    <i class="fa-solid fa-circle-xmark"></i> {{ session('error') }}
</div>
@endif

{{-- MAIN CONTENT --}}
<main class="pt-16">
    @yield('content')
</main>

{{-- FOOTER --}}
<footer class="bg-navy-950 text-white mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-10 mb-10">

            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-9 h-9 bg-gold-500 rounded-lg flex items-center justify-center">
                        <i class="fa-solid fa-microchip text-navy-900"></i>
                    </div>
                    <div>
                        <p class="font-extrabold text-base leading-none">WinTech</p>
                        <p class="text-gold-400 text-xs">Institute</p>
                    </div>
                </div>
                <p class="text-white/50 text-sm leading-relaxed">Empowering Minds Through Technology. Quality IT education for all.</p>
                <div class="flex gap-3 mt-4">
                    <a href="https://facebook.com/wintechinstitute" target="_blank" class="w-8 h-8 bg-white/10 hover:bg-gold-500 rounded-lg flex items-center justify-center transition-colors">
                        <i class="fa-brands fa-facebook-f text-sm"></i>
                    </a>
                    <a href="https://wa.me/94784161920" target="_blank" class="w-8 h-8 bg-white/10 hover:bg-green-500 rounded-lg flex items-center justify-center transition-colors">
                        <i class="fa-brands fa-whatsapp text-sm"></i>
                    </a>
                </div>
            </div>

            <div>
                <h4 class="font-bold text-sm uppercase tracking-wider text-gold-400 mb-4">Quick Links</h4>
                <ul class="space-y-2 text-sm text-white/60">
                    <li><a href="{{ route('courses.index') }}"      class="hover:text-gold-400 transition-colors">Courses</a></li>
                    <li><a href="{{ route('grade.index') }}"        class="hover:text-gold-400 transition-colors">Grade Classes</a></li>
                    <li><a href="{{ route('online-classes.index') }}" class="hover:text-gold-400 transition-colors">Online Classes</a></li>
                    <li><a href="{{ route('gallery.index') }}"      class="hover:text-gold-400 transition-colors">Gallery</a></li>
                    <li><a href="{{ route('papers.index') }}"       class="hover:text-gold-400 transition-colors">Past Papers</a></li>
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
            <p>&copy; {{ date('Y') }} WinTech Institute. All rights reserved.</p>
            <p>Chathuranga Dissanayaka</p>
        </div>
    </div>
</footer>

{{-- WHATSAPP FLOAT --}}
{{-- WHATSAPP FLOAT (LEFT SIDE) --}}
<a href="https://wa.me/94784161920" target="_blank" class="whatsapp-float">
    <i class="fa-brands fa-whatsapp"></i>
</a>

{{-- SCROLL TO TOP (RIGHT SIDE) --}}
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



<script>
const scrollBtn = document.getElementById("scrollTopBtn");

// Show button when scrolling
window.onscroll = function () {
    if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
        scrollBtn.style.display = "flex";
    } else {
        scrollBtn.style.display = "none";
    }
};

// Scroll to top smooth
scrollBtn.addEventListener("click", () => {
    window.scrollTo({
        top: 0,
        behavior: "smooth"
    });
});
</script>
</body>
</html>