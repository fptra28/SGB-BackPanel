<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $table = 'banners'; // Nama tabel di database

    protected $fillable = [
        'title',
        'description',
        'image',
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
}
