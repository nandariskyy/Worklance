<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login', ['error' => null]);
    }

    public function loginAdmin()
    {
        return view('admin.login', ['error' => null]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            if (auth()->user()->id_role == 1) {
                return redirect()->route('admin.dashboard');
            }
            
            return redirect()->intended('/');
        }

        return back()->withInput($request->only('email'))->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function register()
    {
        return view('auth.register', ['error' => null]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'unique:pengguna,email'],
            'username' => ['required', 'unique:pengguna,username'],
            'password' => ['required', 'min:3'],
            'no_telp' => ['nullable'],
        ], [
            'email.unique' => 'Email sudah terdaftar.',
            'username.unique' => 'Username sudah digunakan.',
            'password.min' => 'Password minimal 3 karakter.'
        ]);

        $user = User::create([
            'id_role' => 2, // 2 = Klien
            'username' => $request->username,
            'nama_pengguna' => $request->username,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
