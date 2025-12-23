<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CustomerAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('dreamy-store.auth.customer-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            return redirect('/')->with('success', 'Selamat datang kembali!'); 
        }

        return back()->withErrors([
            'email' => 'Email atau password yang kamu masukkan salah.',
        ])->withInput($request->only('email'));
    }

    public function showRegisterForm()
    {
        return view('dreamy-store.auth.customer-register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:Ms_User,email',
            'password' => 'required|string|min:8|confirmed',
            'nomor_hp' => 'required|string|max:15',
        ]);

        $user = User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'nomor_hp' => $validated['nomor_hp'],
            'password' => Hash::make($validated['password']),
            'role' => 'pelanggan',
            'email_verified_at' => now(), 
        ]);

        Auth::login($user);

        return redirect('/')->with('success', 'Akun berhasil dibuat! Selamat belanja.');
    }
}