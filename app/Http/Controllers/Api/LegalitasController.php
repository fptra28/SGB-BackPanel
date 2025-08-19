<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Legalitas;
use Illuminate\Http\Request;

class LegalitasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $legalitas = Legalitas::all();

        return response()->json([
            'status' => 200,
            'message' => 'Data Legalitas berhasil diambil',
            'data' => $legalitas,
        ], 200);
    }
}
