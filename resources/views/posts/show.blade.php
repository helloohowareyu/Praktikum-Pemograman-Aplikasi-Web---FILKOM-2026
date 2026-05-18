{{-- View: detail satu post (READ - publik) --}}
@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <div class="card">
        {{-- Judul post --}}
        <h1 style="font-size:1.6rem; margin-bottom:8px;">{{ $post->title }}</h1>

        {{-- Info penulis dan waktu --}}
        <p style="color:#718096; font-size:0.87rem; margin-bottom:16px;">
            Ditulis oleh: <strong>{{ $post->user->name }}</strong> &bull;
            {{ $post->created_at->format('d M Y, H:i') }}
        </p>

        <hr style="border-color:#e2e8f0; margin-bottom:16px;">

        {{-- Isi post lengkap - nl2br untuk menjaga baris baru --}}
        <div style="line-height:1.7;">
            {!! nl2br(e($post->body)) !!}
        </div>

        <div style="margin-top:20px;">
            {{-- Tombol kembali ke daftar (publik) --}}
            <a href="{{ route('posts.index') }}" class="btn btn-primary">← Kembali</a>

            {{-- Tombol edit & hapus hanya untuk user yang login --}}
            @auth
                <a href="{{ route('posts.edit', $post) }}" class="btn btn-warning" style="margin-left:8px;">Edit</a>

                {{-- Form delete --}}
                <form action="{{ route('posts.destroy', $post) }}" method="POST" style="display:inline; margin-left:8px;">
                    @csrf
                    @method('DELETE')
                    <button
                        type="submit"
                        class="btn btn-danger"
                        onclick="return confirm('Yakin ingin menghapus post ini?')"
                    >
                        Hapus
                    </button>
                </form>
            @endauth
        </div>
    </div>
@endsection
