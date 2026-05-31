<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    /**
     * Tampilkan halaman register
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.register');
    }

    /**
     * Process login
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|min:3',
            'password' => 'required|string|min:4',
        ], [
            'username.required' => 'Username harus diisi',
            'username.min' => 'Username minimal 3 karakter',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 4 karakter',
        ]);

        // Coba login dengan username
        $user = User::where('name', $validated['username'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return back()->withErrors(['login' => 'Username atau password salah'])->withInput();
        }

        Auth::login($user, $request->boolean('remember'));

        return redirect()->route('dashboard')->with('success', 'Selamat datang, ' . $user->name . '!');
    }

    /**
     * Process register
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'fullname' => 'required|string|min:2|max:255',
            'password' => 'required|string|min:4',
            'password_confirmation' => 'required|string|same:password',
            'terms' => 'accepted',
        ], [
            'fullname.required' => 'Nama lengkap harus diisi',
            'fullname.min' => 'Nama lengkap minimal 2 karakter',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 4 karakter',
            'password_confirmation.same' => 'Konfirmasi password tidak cocok',
            'terms.accepted' => 'Anda harus menerima syarat dan ketentuan',
        ]);

        // Cek apakah username sudah terdaftar
        if (User::where('name', $validated['fullname'])->exists()) {
            return back()->withErrors(['fullname' => 'Nama ini sudah terdaftar'])->withInput();
        }

        // Buat user baru
        $user = User::create([
            'name' => $validated['fullname'],
            'email' => strtolower(str_replace(' ', '.', $validated['fullname'])) . '@metamedia.local',
            'password' => Hash::make($validated['password']),
        ]);

        // Auto login setelah register
        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Pendaftaran berhasil! Selamat bergabung, ' . $user->name . '!');
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('invitation.index')->with('success', 'Anda telah logout');
    }
}
