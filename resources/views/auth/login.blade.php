@extends('layouts.app')
@section('title', 'Student Login')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-navy-950 to-navy-800 flex items-center justify-center px-4 py-16">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-gold-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-graduation-cap text-navy-900 text-2xl"></i>
            </div>
            <h1 class="text-2xl font-extrabold text-white">Student Portal</h1>
            <p class="text-white/50 text-sm mt-1">Login to view your results</p>
        </div>

        <div class="bg-white rounded-2xl shadow-2xl p-8">
            @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm mb-5 flex items-center gap-2">
                <i class="fa-solid fa-circle-xmark"></i> {{ $errors->first() }}
            </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Index Number or Email</label>
                    <input type="text" name="login" value="{{ old('login') }}"
                        class="form-input" placeholder="WIN2024001 or student@email.com" required autofocus>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Password</label>
                    <input type="password" name="password"
                        class="form-input" placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn-primary w-full justify-center py-3">
                    <i class="fa-solid fa-right-to-bracket"></i> Login
                </button>
            </form>

       <div class="mt-6 pt-5 border-t border-slate-100 text-center space-y-2">
    <p class="text-sm text-slate-500">New student?
        <a href="{{ route('register') }}" class="text-navy-700 font-semibold hover:text-gold-500">Register here →</a>
    </p>
    <p class="text-sm text-slate-500">Admin?
        <a href="{{ route('admin.login') }}" class="text-navy-700 font-semibold hover:text-gold-500">Admin Login →</a>
    </p>
</div>
        </div>

        <p class="text-center text-white/40 text-xs mt-6">
            © {{ date('Y') }} WinTech Institute
        </p>
    </div>
</div>
@endsection