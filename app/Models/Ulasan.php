<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'user_id',
        'content',
        'rating',
    ];

        // Relasi ke Buku
        public function book()
        {
            return $this->belongsTo(Book::class);
        }
    
        // Relasi ke User
        public function user()
        {
            return $this->belongsTo(User::class);
        }
    
}
