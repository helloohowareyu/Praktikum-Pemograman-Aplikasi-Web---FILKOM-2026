{{-- View: form edit post (UPDATE - hanya untuk yang sudah login) --}}
@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
    <div style="max-width:600px; margin:0 auto;">
        <div class="card">
            <h1 style="font-size:1.4rem; margin-bottom:20px;">🖊️ Edit Post</h1>

            {{--
                Form update menggunakan method POST dengan spoofing @method('PUT')
                karena HTML form tidak mendukung method PUT secara native
            --}}
            <form action="{{ route('posts.update', $post) }}" method="POST">
                @csrf
                @method('PUT') {{-- Method spoofing: Laravel akan membaca ini sebagai PUT request --}}

                {{-- Field Judul - pre-filled dengan data lama --}}
                <div class="form-group">
                    <label for="title">Judul</label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="{{ old('title', $post->title) }}"
                        required
                    >
                    @error('title')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Field Isi Post - pre-filled dengan data lama --}}
                <div class="form-group">
                    <label for="body">Isi Post</label>
                    <textarea
                        id="body"
                        name="body"
                        required
                    >{{ old('body', $post->body) }}</textarea>
                    @error('body')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <div style="display:flex; gap:8px;">
                    <button type="submit" class="btn btn-warning">Update Post</button>
                    <a href="{{ route('posts.index') }}" class="btn btn-primary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
