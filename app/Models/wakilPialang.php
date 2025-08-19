<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class wakilPialang extends Model
{
    use HasFactory;

    protected $table = 'wakil_pialangs';

    protected $fillable = [
        'image',
        'nomor_id',
        'nama',
        'status'
    ];
}
