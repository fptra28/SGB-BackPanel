<?php

namespace App\Models;


use Carbon\Carbon;
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

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)
            ->timezone('Asia/Jakarta')
            ->format('d F Y, H:i');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)
            ->timezone('Asia/Jakarta')
            ->format('d F Y, H:i');
    }

    // Relasi ke model User (Penulis berita)
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
