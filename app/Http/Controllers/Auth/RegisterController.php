<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:100',
            'email'        => 'nullable|email|unique:users,email',
            'phone'        => 'required|string|max:20',
            'address'      => 'nullable|string|max:200',
            'password'     => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name'         => $request->name,
            'email'        => $request->email,
            'phone'        => $request->phone,
            'address'      => $request->address,
            'password'     => Hash::make($request->password),
            'user_type'    => 'student',
            'is_active'    => false,
            'reg_status'   => 'pending',
        ]);

        return redirect()->route('login')
            ->with('success', 'Registration successful! Please wait for admin approval before logging in.');
    }
}