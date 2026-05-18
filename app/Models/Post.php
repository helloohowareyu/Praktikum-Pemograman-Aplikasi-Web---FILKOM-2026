<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// Model Post merepresentasikan tabel 'posts' di database
class Post extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi secara massal (mass assignment)
    protected $fillable = ['title', 'body', 'user_id'];

    /**
     * Relasi: setiap post dimiliki oleh satu user (many-to-one)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
