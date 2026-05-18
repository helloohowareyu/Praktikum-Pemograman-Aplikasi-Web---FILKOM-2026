<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;

// =====================
// ROUTES PUBLIK - Bisa diakses siapa saja (tanpa login)
// =====================

// Halaman utama redirect ke daftar post
Route::get('/', function () {
    return redirect()->route('posts.index');
});

// READ: Daftar semua post (publik)
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

// READ: Detail satu post (publik)
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show')->where('post', '[0-9]+');

// =====================
// ROUTES AUTENTIKASI - Form login & register (hanya untuk tamu/belum login)
// =====================
Route::middleware('guest')->group(function () {
    // Form registrasi
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Form login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Logout (hanya untuk yang sudah login)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// =====================
// ROUTES TERPROTEKSI - Hanya bisa diakses oleh user yang sudah login
// Middleware 'auth' akan redirect ke /login jika belum login
// =====================
Route::middleware('auth')->group(function () {
    // CREATE: Form tambah post baru
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

    // UPDATE: Form edit post
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');

    // DELETE: Hapus post
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
});
