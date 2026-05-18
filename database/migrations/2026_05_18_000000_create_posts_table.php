<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration untuk membuat tabel posts
return new class extends Migration
{
    /**
     * Jalankan migration - membuat tabel posts
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();                          // Primary key auto increment
            $table->string('title');               // Judul post
            $table->text('body');                  // Isi/konten post
            $table->foreignId('user_id')           // Relasi ke tabel users (penulis)
                  ->constrained()
                  ->onDelete('cascade');
            $table->timestamps();                  // created_at & updated_at
        });
    }

    /**
     * Batalkan migration - hapus tabel posts
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
