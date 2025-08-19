<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KantorCabang extends Model
{
    use HasFactory;

    protected $table = 'kantor_cabangs';

    protected $fillable = [
        'nama_kantor_cabang',
        'alamat_kantor_cabang',
        'fax_kantor_cabang',
        'telepon_kantor_cabang',
        'maps_kantor_cabang'
    ];
}
