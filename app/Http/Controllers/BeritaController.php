<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BeritaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil data dari API menggunakan HTTP client
        $response = Http::get('http://sgb-backpanel.test/api/berita');

        // Jika request API sukses
        if ($response->successful()) {
            $beritas = $response->json(); // Mendapatkan data dalam format JSON
        } else {
            $beritas = [];
        }

        // Kembalikan data ke view
        return view('berita.berita', compact('beritas'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('berita.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'Judul'  => 'required|string|max:100|unique:beritas,Judul',
            'Isi'    => 'required|string',
            'author_id' => 'required|exists:users,id',
            'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image4' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image5' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imageNames = [];

        // Simpan gambar dengan nama unik
        for ($i = 1; $i <= 5; $i++) {
            $imageField = 'image' . $i;
            if ($request->hasFile($imageField)) {
                $file = $request->file($imageField);
                $fileName = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('uploads/berita', $fileName, 'public');

                $imageNames[$imageField] = $fileName;
            }
        }

        // Kirim data ke API
        try {
            $response = Http::post('http://sgb-backpanel.test/api/berita', [
                'image1' => $imageNames['image1'] ?? null,
                'image2' => $imageNames['image2'] ?? null,
                'image3' => $imageNames['image3'] ?? null,
                'image4' => $imageNames['image4'] ?? null,
                'image5' => $imageNames['image5'] ?? null,
                'Judul'  => $request->Judul,
                'Isi'    => $request->Isi,
                'author_id' => $request->author_id,
            ]);

            if ($response->successful()) {
                return redirect()->route('berita.berita')->with('success', 'Berita berhasil ditambahkan!');
            }

            throw new \Exception('Gagal menghubungi API.');
        } catch (\Exception $e) {
            return redirect()->route('berita.create')->with('error', 'Gagal menambahkan berita! ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $judul)
    {
        // Encode judul agar sesuai dengan format URL
        $encodedJudul = urlencode($judul);

        // Panggil API detail berita berdasarkan jdID
        $response = Http::get("http://sgb-backpanel.test/api/berita/detail?jdID={$encodedJudul}");

        if ($response->successful()) {
            $berita = $response->json(); // Ambil data JSON dari API
        } else {
            $berita = null; // Jika gagal, set null
        }

        // Kembalikan data ke view detail berita
        return view('berita.detail', compact('berita'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $response = Http::get("http://sgb-backpanel.test/api/berita/edit?id={$id}");

        if ($response->failed()) {
            abort(404, 'Berita tidak ditemukan');
        }

        $berita = $response->json('data'); // Ambil langsung bagian 'data'

        return view('berita.edit', compact('berita'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'Judul'  => 'required|string|max:100',
            'Isi'    => 'required|string',
            'author_id' => 'required|exists:users,id',
            'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image4' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image5' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imageNames = [];

        // Simpan gambar jika ada yang diunggah
        for ($i = 1; $i <= 5; $i++) {
            $imageField = 'image' . $i;
            if ($request->hasFile($imageField)) {
                $file = $request->file($imageField);
                $fileName = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('uploads/berita', $fileName, 'public');

                $imageNames[$imageField] = $fileName;
            }
        }

        // Kirim data ke API
        try {
            $response = Http::put("http://sgb-backpanel.test/api/berita/edit/{$id}", array_merge([
                'Judul'  => $request->Judul,
                'Isi'    => $request->Isi,
                'author_id' => $request->author_id,
            ], $imageNames));

            if ($response->successful()) {
                return redirect()->route('berita.berita')->with('success', 'Berita berhasil diperbarui!');
            }

            throw new \Exception('Gagal menghubungi API.');
        } catch (\Exception $e) {
            return redirect()->route('berita.edit', ['id' => $id])->with('error', 'Gagal memperbarui berita! ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
