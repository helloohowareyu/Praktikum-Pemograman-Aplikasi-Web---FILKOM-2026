{{-- View: halaman login --}}
@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div style="max-width:400px; margin:0 auto;">
    <div class="card">
        <h1 style="margin-bottom:20px; font-size:1.4rem;">Login</h1>

        {{-- Form login - submit ke route 'login' dengan method POST --}}
        <form action="{{ route('login') }}" method="POST">
            @csrf {{-- Token CSRF untuk keamanan --}}

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
                    placeholder="Masukkan password"
                    required
                >
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%;">Login</button>
        </form>

        <p style="margin-top:12px; text-align:center; font-size:0.9rem;">
            Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
        </p>
    </div>
</div>
@endsection
