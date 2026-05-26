{{-- View: daftar semua post (READ - publik) --}}
@extends('layouts.app')

@section('title', 'Daftar Post')

@section('content')
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h1 style="font-size:1.5rem;">Daftar Post</h1>

        {{-- Tombol tambah post hanya muncul jika sudah login --}}
        @auth
            <a href="{{ route('posts.create') }}" class="btn btn-success">+ Tambah Post</a>
        @endauth
    </div>

    {{-- Tampilkan pesan jika belum ada post --}}
    @if ($posts->isEmpty())
        <div class="card" style="text-align:center; color:#718096;">
            <p>Belum ada post. @auth Klik "+ Tambah Post" untuk memulai! @endauth</p>
        </div>
    @else
        {{-- Loop tampilkan semua post --}}
        @foreach ($posts as $post)
            <div class="card">
                <h2>
                    {{-- Link ke halaman detail post --}}
                    <a href="{{ route('posts.show', $post) }}" style="color:#2d3748; text-decoration:none;">
                        {{ $post->title }}
                    </a>
                </h2>
                {{-- Info penulis dan tanggal --}}
                <p style="margin:6px 0;">
                    Oleh: <strong>{{ $post->user->name }}</strong> &bull;
                    {{ $post->created_at->format('d M Y, H:i') }}
                </p>
                {{-- Cuplikan isi post (100 karakter pertama) --}}
                <p style="margin-top:8px;">{{ Str::limit($post->body, 100) }}</p>

                {{-- Tombol aksi: hanya muncul jika sudah login --}}
                @auth
                    <div style="margin-top:10px;">
                        <a href="{{ route('posts.edit', $post) }}" class="btn btn-warning">Edit</a>

                        {{-- Form delete menggunakan method spoofing (_method=DELETE) --}}
                        <form action="{{ route('posts.destroy', $post) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE') {{-- HTML form hanya mendukung GET/POST, gunakan spoofing --}}
                            <button
                                type="submit"
                                class="btn btn-danger"
                                onclick="return confirm('Yakin ingin menghapus post ini?')"
                            >
                                Hapus
                            </button>
                        </form>
                    </div>
                @endauth
            </div>
        @endforeach
    @endif
@endsection
