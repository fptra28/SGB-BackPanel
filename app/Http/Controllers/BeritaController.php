<?php

namespace App\Http\Controllers;

use App\Models\berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

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
        // Mengambil parameter pencarian dari request
        $search = request()->query('search');

        // Mengambil data dari API menggunakan HTTP client
        $response = Http::get("http://sgb-backpanel.test/api/berita");

        if ($response->successful()) {
            $data = $response->json();
            $currentPage = request()->get('page', 1);
            $perPage = 10;

            // Konversi array ke Laravel Collection
            $beritasCollection = collect($data);

            // Filter berdasarkan pencarian (hanya pada Judul)
            if (!empty($search)) {
                $beritasCollection = $beritasCollection->filter(function ($item) use ($search) {
                    return stripos($item['Judul'], $search) !== false;
                });
            }

            // Lakukan pagination manual dengan Collection Laravel
            $beritas = new LengthAwarePaginator(
                $beritasCollection->forPage($currentPage, $perPage),
                $beritasCollection->count(),
                $perPage,
                $currentPage,
                ['path' => request()->url(), 'query' => request()->query()]
            );
        } else {
            $beritas = new LengthAwarePaginator([], 0, 10);
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
        $request->validate([
            'image1'    => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'Judul'     => 'required|string|max:100|unique:beritas,Judul',
            'Isi'       => 'required|string',
            'author_id' => 'required|exists:users,id',
        ]);

        try {
            // Menyimpan gambar ke folder public/images/berita
            $fileName = time() . '_' . $request->file('image1')->getClientOriginalName();
            $request->file('image1')->move(public_path('images/berita'), $fileName);

            // Simpan ke database
            $berita = Berita::create([
                'image1'    => $fileName, // Simpan hanya nama file
                'Judul'     => $request->Judul,
                'Isi'       => $request->Isi,
                'author_id' => $request->author_id,
            ]);

            return redirect()->route('berita.berita')->with('success', 'Berita berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan berita! ' . $e->getMessage());
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
        $request->validate([
            'Judul'  => 'required|string|max:100',
            'Isi'    => 'required|string',
            'author_id' => 'required|exists:users,id',
            'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $berita = Berita::findOrFail($id);

            // Jika ada file baru diunggah
            if ($request->hasFile('image1')) {
                // Hapus gambar lama jika ada
                $oldImagePath = public_path('images/berita/' . $berita->image1);
                if ($berita->image1 && file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }

                // Simpan gambar baru
                $imageName = time() . '_' . $request->file('image1')->getClientOriginalName();
                $request->file('image1')->move(public_path('images/berita'), $imageName);
                $berita->image1 = $imageName;
            }

            // Update berita
            $berita->update([
                'Judul'     => $request->Judul,
                'Isi'       => $request->Isi,
                'author_id' => $request->author_id,
                'image1'    => $berita->image1, // Gunakan gambar lama jika tidak ada upload baru
            ]);

            return redirect()->route('berita.berita')->with('success', 'Berita berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui berita! ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $berita = Berita::find($id);

        if (!$berita) {
            return redirect()->route('berita.berita')->with('error', 'Berita tidak ditemukan.');
        }

        // Hapus gambar jika ada
        if ($berita->image1) {
            $filePath = public_path('images/berita/' . $berita->image1);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        // Hapus data berita dari database
        $berita->delete();

        return redirect()->route('berita.berita')->with('success', 'Berita berhasil dihapus.');
    }
}
