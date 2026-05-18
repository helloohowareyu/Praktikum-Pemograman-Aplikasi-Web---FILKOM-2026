<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

// Controller untuk menangani autentikasi (login, register, logout)
class AuthController extends Controller
{
    // =====================
    // REGISTER
    // =====================

    /**
     * Tampilkan form registrasi
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Proses pendaftaran pengguna baru
     */
    public function register(Request $request)
    {
        // Validasi input dari form registrasi
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed', // 'confirmed' butuh field password_confirmation
        ]);

        // Buat user baru di database (password otomatis di-hash oleh model)
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Redirect ke halaman login setelah berhasil daftar
        return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan login.');
    }

    // =====================
    // LOGIN
    // =====================

    /**
     * Tampilkan form login
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Proses login pengguna
     */
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Coba autentikasi dengan kredensial yang diberikan
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Regenerasi session untuk keamanan (mencegah session fixation)
            $request->session()->regenerate();

            return redirect()->route('posts.index')->with('success', 'Login berhasil!');
        }

        // Jika gagal, kembalikan ke form login dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    // =====================
    // LOGOUT
    // =====================

    /**
     * Proses logout pengguna
     */
    public function logout(Request $request)
    {
        Auth::logout(); // Hapus sesi autentikasi

        // Invalidasi dan regenerasi token session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('posts.index')->with('success', 'Berhasil logout.');
    }
}
