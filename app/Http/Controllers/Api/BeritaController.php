<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita;

class BeritaController extends Controller
{
    // Ambil semua berita
    public function index()
    {
        $beritas = Berita::with('author')->latest()->get();
        return response()->json($beritas);
    }

    // Ambil berita berdasarkan judul (jdID)
    public function showByTitle(Request $request)
    {
        $judul = $request->query('jdID'); // Ambil parameter dari URL

        if (!$judul) {
            return response()->json([
                'success' => false,
                'message' => 'Parameter jdID diperlukan'
            ], 400);
        }

        // Cari berita berdasarkan judul
        $berita = Berita::with('author')
            ->where('Judul', $judul)
            ->first();

        if (!$berita) {
            return response()->json([
                'success' => false,
                'message' => 'Berita tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $berita
        ], 200);
    }

    // Ambil berita berdasarkan ID
    public function showById(Request $request)
    {
        $id = $request->query('id');

        abort_if(!is_numeric($id), 400, 'Parameter id harus berupa angka');

        $berita = Berita::with('author')->find($id);

        if (!$berita) {
            return response()->json([
                'success' => false,
                'message' => 'Berita tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $berita
        ]);
    }
}
