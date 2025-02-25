<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class berita extends Model
{
    use HasFactory;

    protected $table = 'beritas'; // Nama tabel di database

    protected $fillable = [
        'image1',
        'Judul',
        'Isi',
        'author_id',
    ];

    // Relasi ke model User (Penulis berita)
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
