@extends('layouts.app')
@section('title', 'Student Registration')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-navy-950 to-navy-800 flex items-center justify-center px-4 py-16">
    <div class="w-full max-w-lg">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-gold-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-user-plus text-navy-900 text-2xl"></i>
            </div>
            <h1 class="text-2xl font-extrabold text-white">Student Registration</h1>
            <p class="text-white/50 text-sm mt-1">Register to access WinTech student portal</p>
        </div>

        <div class="bg-white rounded-2xl shadow-2xl p-8">

            {{-- Info Banner --}}
            <div class="bg-amber-50 border border-amber-200 rounded-xl px-4 py-3 mb-6 flex items-start gap-3">
                <i class="fa-solid fa-circle-info text-amber-500 mt-0.5"></i>
                <p class="text-amber-700 text-sm">Your registration will be reviewed by admin before you can login. You will be notified once approved.</p>
            </div>

            @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm mb-5">
                <ul class="space-y-1">
                    @foreach($errors->all() as $error)
                    <li class="flex items-center gap-2"><i class="fa-solid fa-circle-xmark"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('register.post') }}" method="POST" class="space-y-5">
                @csrf
                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-navy-900 mb-1.5">Full Name *</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="form-input" placeholder="Your full name" required autofocus>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-navy-900 mb-1.5">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="form-input" placeholder="you@email.com">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-navy-900 mb-1.5">Phone *</label>
                        <input type="text" name="phone" value="{{ old('phone') }}"
                            class="form-input" placeholder="07X XXX XXXX" required>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-navy-900 mb-1.5">Address</label>
                        <input type="text" name="address" value="{{ old('address') }}"
                            class="form-input" placeholder="Your address">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-navy-900 mb-1.5">Password *</label>
                        <input type="password" name="password" class="form-input" placeholder="••••••••" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-navy-900 mb-1.5">Confirm Password *</label>
                        <input type="password" name="password_confirmation" class="form-input" placeholder="••••••••" required>
                    </div>
                </div>
                <button type="submit" class="btn-gold w-full justify-center py-3 text-base">
                    <i class="fa-solid fa-user-plus"></i> Submit Registration
                </button>
            </form>

            <div class="mt-6 pt-5 border-t border-slate-100 text-center">
                <p class="text-sm text-slate-500">Already registered?
                    <a href="{{ route('login') }}" class="text-navy-700 font-semibold hover:text-gold-500">Login here →</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection