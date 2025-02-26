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

    private $baseUrl;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->baseUrl = config('app.url'); // Ambil dari .env
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil parameter pencarian dari request
        $search = request()->query('search');

        // Mengambil data dari API menggunakan HTTP client
        $response = Http::get("{$this->baseUrl}/api/berita");

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
        // Validasi input
        $request->validate([
            'image1'    => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'Judul'     => 'required|string|max:100|unique:beritas,Judul',
            'Isi'       => 'required|string',
            'author_id' => 'required|exists:users,id',
        ]);

        try {
            // Ambil nama asli file dan simpan ke dalam folder public/uploads/berita
            $fileName = time() . '_' . $request->file('image1')->getClientOriginalName();
            $request->file('image1')->storeAs('public/uploads', $fileName);

            // Simpan data ke database dengan hanya nama file
            $berita = Berita::create([
                'image1'    => $fileName, // Hanya menyimpan nama file
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
        $response = Http::get("{$this->baseUrl}/api/berita/detail?jdID={$encodedJudul}");

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
        $response = Http::get("{$this->baseUrl}/api/berita/edit?id={$id}");

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
        ]);

        try {
            // Ambil berita yang akan diupdate
            $berita = Berita::findOrFail($id);

            // Simpan gambar jika ada yang diunggah
            if ($request->hasFile('image1')) {
                // Hapus gambar lama jika ada
                if ($berita->image1 && file_exists(storage_path('app/public/uploads/' . $berita->image1))) {
                    unlink(storage_path('app/public/uploads/' . $berita->image1));
                }

                // Simpan gambar baru dengan hanya nama file
                $fileName = time() . '_' . $request->file('image1')->getClientOriginalName();
                $request->file('image1')->storeAs('public/uploads', $fileName);
            } else {
                $fileName = $berita->image1; // Gunakan gambar lama jika tidak diubah
            }

            // Update berita di database
            $berita->update([
                'Judul'     => $request->Judul,
                'Isi'       => $request->Isi,
                'author_id' => $request->author_id,
                'image1'    => $fileName, // Hanya menyimpan nama file
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

        // Cek apakah berita memiliki gambar
        if ($berita->image1) {
            $filePath = 'public/uploads/' . $berita->image1; // Sesuaikan dengan lokasi penyimpanan

            // Hapus file jika ada di penyimpanan
            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }
        }

        // Hapus data berita dari database
        $berita->delete();

        return redirect()->route('berita.berita')->with('success', 'Berita berhasil dihapus.');
    }
}
