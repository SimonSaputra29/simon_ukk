<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'penulis',
        'kategori',
        'stok',
        'gambar',
    ];

    public function ulasan()
    {
        return $this->hasMany(Ulasan::class);
    }
}
