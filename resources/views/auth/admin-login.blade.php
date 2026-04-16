<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — WinTech</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-navy-950 min-h-screen flex items-center justify-center px-4">

<div class="w-full max-w-md">
    <div class="text-center mb-8">
        <div class="w-16 h-16 bg-gold-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <i class="fa-solid fa-shield-halved text-navy-900 text-2xl"></i>
        </div>
        <h1 class="text-2xl font-extrabold text-white">Admin Panel</h1>
        <p class="text-white/50 text-sm mt-1">WinTech Institute Management</p>
    </div>

    <div class="bg-white rounded-2xl shadow-2xl p-8">
        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm mb-5 flex items-center gap-2">
            <i class="fa-solid fa-circle-xmark"></i> {{ $errors->first() }}
        </div>
        @endif

        <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-navy-900 mb-1.5">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="form-input" placeholder="admin@wintech.lk" required autofocus>
            </div>
            <div>
                <label class="block text-sm font-semibold text-navy-900 mb-1.5">Password</label>
                <input type="password" name="password"
                    class="form-input" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn-primary w-full justify-center py-3">
                <i class="fa-solid fa-right-to-bracket"></i> Login to Admin
            </button>
        </form>

        <div class="mt-6 pt-5 border-t border-slate-100 text-center">
            <a href="{{ route('home') }}" class="text-sm text-slate-400 hover:text-navy-700">
                ← Back to Website
            </a>
        </div>
    </div>
</div>

</body>
</html>