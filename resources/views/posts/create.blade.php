{{-- View: form buat post baru (CREATE - hanya untuk yang sudah login) --}}
@extends('layouts.app')

@section('title', 'Tambah Post')

@section('content')
    <div style="max-width:600px; margin:0 auto;">
        <div class="card">
            <h1 style="font-size:1.4rem; margin-bottom:20px;">Tambah Post Baru</h1>

            {{-- Form create - submit ke route 'posts.store' dengan method POST --}}
            <form action="{{ route('posts.store') }}" method="POST">
                @csrf {{-- Token CSRF wajib ada --}}

                {{-- Field Judul --}}
                <div class="form-group">
                    <label for="title">Judul</label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="{{ old('title') }}"
                        placeholder="Masukkan judul post"
                        required
                    >
                    {{-- Tampilkan error validasi jika ada --}}
                    @error('title')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Field Isi Post --}}
                <div class="form-group">
                    <label for="body">Isi Post</label>
                    <textarea
                        id="body"
                        name="body"
                        placeholder="Tulis isi post di sini..."
                        required
                    >{{ old('body') }}</textarea>
                    @error('body')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <div style="display:flex; gap:8px;">
                    <button type="submit" class="btn btn-success">Simpan Post</button>
                    <a href="{{ route('posts.index') }}" class="btn btn-primary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
