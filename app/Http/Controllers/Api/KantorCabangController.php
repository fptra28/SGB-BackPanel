<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KantorCabang;
use Illuminate\Http\Request;

class KantorCabangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kantorCabang = KantorCabang::all();

        return response()->json([
            'status'  => 200,
            'message' => 'Data Kantor Cabang berhasil diambil',
            'data'    => $kantorCabang,
        ], 200);
    }
}
