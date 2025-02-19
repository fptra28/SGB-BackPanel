<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita;

class BeritaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store', 'update', 'destroy']);
    }
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
        ]);
    }

    // Tambah berita baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'image1' => 'required|string',
            'image2' => 'required|string',
            'image3' => 'required|string',
            'image4' => 'required|string',
            'image5' => 'required|string',
            'Judul'  => 'required|string|max:100|unique:beritas,Judul',
            'Isi'    => 'required|string',
            'author_id' => 'required|exists:users,id', // Pastikan author_id ada di tabel users
        ]);

        // Simpan data ke database
        $berita = Berita::create([
            'image1' => $request->image1,
            'image2' => $request->image2,
            'image3' => $request->image3,
            'image4' => $request->image4,
            'image5' => $request->image5,
            'Judul'  => $request->Judul,
            'Isi'    => $request->Isi,
            'author_id' => $request->author_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berita berhasil ditambahkan!',
            'data'    => $berita
        ], 201);
    }
}
