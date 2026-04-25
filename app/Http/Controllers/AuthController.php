<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nim' => 'required|string|unique:users,nim|max:20',
            'email' => [
                'required', 
                'string', 
                'email', 
                'max:255', 
                'unique:users',
                function ($attribute, $value, $fail) {
                    if (!str_ends_with($value, '@webmail.umm.ac.id')) {
                        $fail('Email harus menggunakan domain @webmail.umm.ac.id');
                    }
                },
            ],
            'department' => 'required|string|max:255',
            'study_program' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $studentRole = Role::where('name', 'student')->first();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nim' => $request->nim,
            'department' => $request->department,
            'study_program' => $request->study_program,
            'password' => Hash::make($request->password),
            'role_id' => $studentRole->id,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Registrasi berhasil! Selamat datang di AccaFlow.');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
