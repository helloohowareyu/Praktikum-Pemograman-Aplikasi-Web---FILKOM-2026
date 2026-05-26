<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Controller untuk operasi CRUD pada Post
class PostController extends Controller
{
    // =====================
    // READ (Public)
    // =====================

    /**
     * Tampilkan semua post - bisa diakses siapa saja (publik)
     */
    public function index()
    {
        // Ambil semua post beserta nama pembuatnya, urut dari terbaru
        $posts = Post::with('user')->latest()->get();

        return view('posts.index', compact('posts'));
    }

    /**
     * Tampilkan detail satu post - bisa diakses siapa saja (publik)
     */
    public function show(Post $post)
    {
        // Laravel otomatis menemukan post berdasarkan ID (route model binding)
        return view('posts.show', compact('post'));
    }

    // =====================
    // CREATE (Auth only)
    // =====================

    /**
     * Tampilkan form untuk membuat post baru - hanya untuk user yang login
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Simpan post baru ke database - hanya untuk user yang login
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'title' => 'required|string|max:255',
            'body'  => 'required|string',
        ]);

        // Buat post baru dengan user_id dari user yang sedang login
        Post::create([
            'title'   => $request->title,
            'body'    => $request->body,
            'user_id' => Auth::id(), // Ambil ID user yang sedang login
        ]);

        return redirect()->route('posts.index')->with('success', 'Post berhasil dibuat!');
    }

    // =====================
    // UPDATE (Auth only)
    // =====================

    /**
     * Tampilkan form edit post - hanya untuk user yang login
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return view('posts.edit', compact('post'));
    }

    /**
     * Update data post di database - hanya untuk user yang login
     */
    public function update(Request $request, Post $post)
    {
        // Validasi input dari form edit
        $request->validate([
            'title' => 'required|string|max:255',
            'body'  => 'required|string',
        ]);

        // Authorization: pastikan user yang sedang login boleh mengubah post ini
        $this->authorize('update', $post);

        // Update kolom title dan body
        $post->update([
            'title' => $request->title,
            'body'  => $request->body,
        ]);

        return redirect()->route('posts.index')->with('success', 'Post berhasil diperbarui!');
    }

    // =====================
    // DELETE (Auth only)
    // =====================

    /**
     * Hapus post dari database - hanya untuk user yang login
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete(); // Hapus post dari database

        return redirect()->route('posts.index')->with('success', 'Post berhasil dihapus!');
    }
}
