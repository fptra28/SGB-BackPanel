<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoLink extends Model
{
    use HasFactory;

    protected $table = 'videos'; // Nama tabel di database

    protected $fillable = [
        'title',
        'image',
        'embed_code',
    ];
}
