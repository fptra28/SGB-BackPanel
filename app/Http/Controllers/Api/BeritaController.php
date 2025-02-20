<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita;

class BeritaController extends Controller
{
    // Middleware yang harus login terlebih dahulu
    public function __construct()
    {
        // $this->middleware('auth:sanctum')->only(['store', 'update', 'destroy']);
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

    // Ubah berita
    // Update berita berdasarkan ID
    public function update(Request $request, $id)
    {
        $berita = Berita::find($id);

        if (!$berita) {
            return response()->json([
                'success' => false,
                'message' => 'Berita tidak ditemukan'
            ], 404);
        }

        // Validasi input
        $request->validate([
            'Judul'  => 'required|string|max:100|unique:beritas,Judul,' . $id,
            'Isi'    => 'required|string',
            'author_id' => 'required|exists:users,id',
        ]);

        // Update data berita
        $berita->update(array_merge(
            $request->only(['Judul', 'Isi', 'author_id']),
            $request->only(['image1', 'image2', 'image3', 'image4', 'image5'])
        ));

        return response()->json([
            'success' => true,
            'message' => 'Berita berhasil diperbarui!',
            'data'    => $berita
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $berita = Berita::find($id);

        if (!$berita) {
            return response()->json([
                'success' => false,
                'message' => 'Berita tidak ditemukan'
            ], 404);
        }

        $berita->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berita berhasil dihapus!'
        ]);
    }
}
