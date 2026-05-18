{{-- View: halaman registrasi pengguna baru --}}
@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div style="max-width:400px; margin:0 auto;">
    <div class="card">
        <h1 style="margin-bottom:20px; font-size:1.4rem;">📝 Buat Akun Baru</h1>

        {{-- Form registrasi - submit ke route 'register' dengan method POST --}}
        <form action="{{ route('register') }}" method="POST">
            @csrf {{-- Token CSRF wajib ada di setiap form POST --}}

            {{-- Field Nama --}}
            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Nama kamu"
                    required
                >
                @error('name')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Field Email --}}
            <div class="form-group">
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="contoh@email.com"
                    required
                >
                @error('email')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Field Password --}}
            <div class="form-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Minimal 6 karakter"
                    required
                >
                @error('password')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Field Konfirmasi Password - harus sama dengan password --}}
            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    placeholder="Ulangi password"
                    required
                >
            </div>

            <button type="submit" class="btn btn-success" style="width:100%;">Daftar</button>
        </form>

        <p style="margin-top:12px; text-align:center; font-size:0.9rem;">
            Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
        </p>
    </div>
</div>
@endsection
