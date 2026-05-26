<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplikasi CRUD Laravel')</title>
    <style>
        /* Reset dasar */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; color: #333; }

        /* Navbar */
        nav {
            background: #2d3748;
            color: white;
            padding: 12px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        nav a { color: white; text-decoration: none; margin-left: 12px; }
        nav a:hover { text-decoration: underline; }
        .nav-brand { font-size: 1.2rem; font-weight: bold; }

        /* Container utama */
        .container { max-width: 900px; margin: 30px auto; padding: 0 16px; }

        /* Alert / pesan notifikasi */
        .alert {
            padding: 10px 16px;
            border-radius: 4px;
            margin-bottom: 16px;
        }
        .alert-success { background: #c6f6d5; color: #276749; border: 1px solid #9ae6b4; }
        .alert-danger  { background: #fed7d7; color: #742a2a; border: 1px solid #fc8181; }

        /* Tombol */
        .btn {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            font-size: 0.9rem;
        }
        .btn-primary  { background: #3182ce; color: white; }
        .btn-success  { background: #38a169; color: white; }
        .btn-warning  { background: #d69e2e; color: white; }
        .btn-danger   { background: #e53e3e; color: white; }
        .btn:hover    { opacity: 0.85; }

        /* Form */
        .form-group { margin-bottom: 14px; }
        .form-group label { display: block; margin-bottom: 4px; font-weight: bold; font-size: 0.9rem; }
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #cbd5e0;
            border-radius: 4px;
            font-size: 0.95rem;
        }
        .form-group textarea { height: 120px; resize: vertical; }
        .error { color: #e53e3e; font-size: 0.82rem; margin-top: 3px; }

        /* Card */
        .card {
            background: white;
            border-radius: 6px;
            padding: 20px;
            margin-bottom: 14px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .card h2 { font-size: 1.1rem; margin-bottom: 6px; }
        .card p  { font-size: 0.85rem; color: #718096; }
    </style>
</head>
<body>

{{-- Navbar navigasi --}}
<nav>
    <a class="nav-brand" href="{{ route('posts.index') }}">CRUD App</a>
    <div>
        @auth
            {{-- Tampil jika sudah login --}}
            <span style="margin-right:8px;">Halo, {{ Auth::user()->name }}!</span>
            <a href="{{ route('posts.create') }}">+ Tambah Post</a>
            {{-- Form logout menggunakan POST untuk keamanan --}}
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-danger" style="margin-left:8px;">Logout</button>
            </form>
        @else
            {{-- Tampil jika belum login --}}
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Register</a>
        @endauth
    </div>
</nav>

{{-- Konten utama dari halaman child --}}
<div class="container">

    {{-- Tampilkan pesan sukses jika ada --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Tampilkan pesan error umum jika ada --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul style="margin-left:16px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Yield konten dari view child --}}
    @yield('content')
</div>

</body>
</html>
