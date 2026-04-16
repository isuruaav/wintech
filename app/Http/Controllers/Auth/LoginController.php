<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLogin()
    {
        return Auth::check() && Auth::user()->isStudent()
            ? redirect()->route('student.results')
            : view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ]);

        $login = $request->login;
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'index_number';

        $user = \App\Models\User::where($field, $login)
            ->where('user_type', 'student')
            ->first();

        if (!$user) {
            return back()->withErrors(['login' => 'No account found with these credentials.'])->withInput();
        }

        if ($user->reg_status === 'pending') {
            return back()->withErrors(['login' => 'Your registration is pending admin approval.'])->withInput();
        }

        if ($user->reg_status === 'rejected') {
            return back()->withErrors(['login' => 'Your registration has been rejected. Please contact us.'])->withInput();
        }

        if (!$user->is_active) {
            return back()->withErrors(['login' => 'Your account has been deactivated.'])->withInput();
        }

        if (\Illuminate\Support\Facades\Auth::attempt([$field => $login, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->route('student.results');
        }

        return back()->withErrors(['login' => 'Incorrect password.'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
