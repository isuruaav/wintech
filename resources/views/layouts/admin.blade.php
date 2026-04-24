<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — WinTech Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 antialiased">

<div class="flex h-screen overflow-hidden">

    {{-- SIDEBAR OVERLAY (mobile) --}}
    <div id="sidebar-overlay" class="hidden fixed inset-0 bg-black/50 z-20 lg:hidden"></div>

    {{-- SIDEBAR --}}
    <aside id="sidebar" class="fixed lg:static inset-y-0 left-0 z-30 w-64 bg-navy-900 flex flex-col -translate-x-full lg:translate-x-0 transition-transform duration-300">

        {{-- Logo --}}
        <div class="flex items-center gap-3 px-5 py-5 border-b border-white/10">
            <div class="w-9 h-9 flex items-center justify-center shrink-0">
                <img src="{{ asset('images/logo.png') }}"
                     alt="WinTech Logo"
                     class="w-10 h-10 object-contain">
            </div>
            <div>
                <p class="text-white font-extrabold leading-none">WinTech</p>
                <p class="text-gold-400 text-xs">Admin Panel</p>
            </div>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-gauge-high w-5 text-center"></i> Dashboard
            </a>

            <p class="text-white/30 text-xs font-semibold uppercase px-3 pt-4 pb-1 tracking-wider">Academic</p>
            <a href="{{ route('admin.courses.index') }}" class="sidebar-link {{ request()->routeIs('admin.courses*') ? 'active' : '' }}">
                <i class="fa-solid fa-book w-5 text-center"></i> Courses
            </a>
            <a href="{{ route('admin.classes.index') }}" class="sidebar-link {{ request()->routeIs('admin.classes*') ? 'active' : '' }}">
                <i class="fa-solid fa-chalkboard w-5 text-center"></i> Grade Classes
            </a>
            <a href="{{ route('admin.teachers.index') }}" class="sidebar-link {{ request()->routeIs('admin.teachers*') ? 'active' : '' }}">
                <i class="fa-solid fa-chalkboard-user w-5 text-center"></i> Teachers
            </a>
            <a href="{{ route('admin.students.index') }}" class="sidebar-link {{ request()->routeIs('admin.students*') ? 'active' : '' }}">
                <i class="fa-solid fa-users w-5 text-center"></i> Students
            </a>
            <a href="{{ route('admin.exams.index') }}" class="sidebar-link {{ request()->routeIs('admin.exams*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-circle-check w-5 text-center"></i> Exams & Results
            </a>
            <a href="{{ route('admin.online-classes.index') }}" class="sidebar-link {{ request()->routeIs('admin.online-classes*') ? 'active' : '' }}">
                <i class="fa-solid fa-video w-5 text-center"></i> Online Classes
            </a>

            <p class="text-white/30 text-xs font-semibold uppercase px-3 pt-4 pb-1 tracking-wider">Media</p>
            <a href="{{ route('admin.gallery.index') }}" class="sidebar-link {{ request()->routeIs('admin.gallery*') ? 'active' : '' }}">
                <i class="fa-solid fa-images w-5 text-center"></i> Gallery
            </a>
            <a href="{{ route('admin.videos.index') }}" class="sidebar-link {{ request()->routeIs('admin.videos*') ? 'active' : '' }}">
                <i class="fa-brands fa-youtube w-5 text-center"></i> Videos
            </a>

            <p class="text-white/30 text-xs font-semibold uppercase px-3 pt-4 pb-1 tracking-wider">Downloads</p>
            <a href="{{ route('admin.papers.index') }}" class="sidebar-link {{ request()->routeIs('admin.papers*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-pdf w-5 text-center"></i> Past Papers
            </a>
            <a href="{{ route('admin.downloads.index') }}" class="sidebar-link {{ request()->routeIs('admin.downloads*') ? 'active' : '' }}">
                <i class="fa-solid fa-download w-5 text-center"></i> Downloads
            </a>

            <p class="text-white/30 text-xs font-semibold uppercase px-3 pt-4 pb-1 tracking-wider">Communication</p>
            <a href="{{ route('admin.announcements.index') }}" class="sidebar-link {{ request()->routeIs('admin.announcements*') ? 'active' : '' }}">
                <i class="fa-solid fa-bullhorn w-5 text-center"></i> Announcements
            </a>
            <a href="{{ route('admin.enquiries.index') }}" class="sidebar-link {{ request()->routeIs('admin.enquiries*') ? 'active' : '' }}">
                <i class="fa-solid fa-inbox w-5 text-center"></i> Enquiries
                @php $newEnq = \App\Models\Enquiry::where('status','new')->count(); @endphp
                @if($newEnq > 0)
                    <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $newEnq }}</span>
                @endif
            </a>

            {{-- SYSTEM --}}
            <p class="text-white/30 text-xs font-semibold uppercase px-3 pt-4 pb-1 tracking-wider">System</p>
            <a href="{{ route('admin.settings.index') }}" class="sidebar-link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                <i class="fa-solid fa-gear w-5 text-center"></i> Settings
            </a>
        </nav>

        {{-- User Info --}}
        <div class="px-4 py-4 border-t border-white/10">
            <div class="flex items-center gap-3 mb-3">
                <img src="{{ Auth::user()->avatar_url }}" class="w-8 h-8 rounded-full object-cover" alt="">
                <div class="min-w-0">
                    <p class="text-white text-sm font-semibold truncate">{{ Auth::user()->name }}</p>
                    <p class="text-white/40 text-xs truncate">{{ Auth::user()->email }}</p>
                </div>
            </div>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button class="w-full flex items-center gap-2 text-white/60 hover:text-white text-sm py-2 px-3 rounded-lg hover:bg-white/10 transition-colors">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        {{-- TOP BAR --}}
        <header class="bg-white border-b border-slate-200 px-5 py-3.5 flex items-center gap-4 shrink-0">
            <button id="sidebar-toggle" class="lg:hidden text-slate-500 hover:text-navy-900">
                <i class="fa-solid fa-bars text-lg"></i>
            </button>
            <div class="min-w-0">
                <h1 class="font-bold text-navy-900 text-base leading-none">@yield('page_title', 'Dashboard')</h1>
                <p class="text-slate-400 text-xs mt-0.5">@yield('breadcrumb', 'WinTech Admin')</p>
            </div>
            <div class="ml-auto flex items-center gap-3">
                <a href="{{ route('home') }}" target="_blank" class="text-slate-400 hover:text-navy-700 text-sm flex items-center gap-1.5">
                    <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                    <span class="hidden sm:inline">View Site</span>
                </a>
            </div>
        </header>

        {{-- FLASH --}}
        @if(session('success'))
        <div class="flash-msg mx-5 mt-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-3 text-sm">
            <i class="fa-solid fa-circle-check text-green-500"></i> {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="flash-msg mx-5 mt-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center gap-3 text-sm">
            <i class="fa-solid fa-circle-xmark text-red-500"></i> {{ session('error') }}
        </div>
        @endif

        {{-- PAGE CONTENT --}}
        <main class="flex-1 overflow-y-auto p-5">
            @yield('content')
        </main>
    </div>
</div>

</body>
</html>