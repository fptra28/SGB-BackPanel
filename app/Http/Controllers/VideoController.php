<?php

namespace App\Http\Controllers;

use App\Models\VideoLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
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
    public function index(Request $request)
    {
        // Ambil query pencarian dari input
        $search = $request->query('search');

        // Query dengan search dan pagination
        $videos = VideoLink::when($search, function ($query, $search) {
            return $query->where('title', 'LIKE', "%{$search}%");
        })
            ->latest()
            ->paginate(10) // Menampilkan 15 data per halaman
            ->appends(['search' => $search]); // Agar pagination tetap menyimpan query search

        return view('video.video', compact('videos'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('video.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'title' => 'required|string|max:100|unique:video_links,title',
            'video_links' => 'required|url',
        ]);

        try {
            // Simpan ke database
            VideoLink::create([
                'title' => $request->title,
                'video_links' => $request->video_links,
            ]);

            return redirect()->route('video.index')->with('success', 'Video berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->route('video.index')->with('error', 'Gagal menambahkan video! ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $response = Http::get("{$this->baseUrl}/api/video/edit/?id={$id}");

        if ($response->failed()) {
            abort(404, 'Berita tidak ditemukan');
        }

        $video = $response->json('data'); // Ambil langsung bagian 'data'

        return view('video.edit', compact('video'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'title' => 'required|string|max:100|unique:video_links,title',
            'video_links' => 'required|url',
        ]);

        try {
            // Ambil berita yang akan diupdate
            $video = VideoLink::findOrFail($id);

            // Update berita di database
            $video->update([
                'title' => $request->title,
                'video_links' => $request->video_links,
            ]);

            return redirect()->route('video.index')->with('success', 'Video berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui berita! ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $video = VideoLink::find($id);

        if (!$video) {
            return redirect()->route('video.index')->with('error', 'Video tidak ditemukan.');
        }

        // Hapus data berita dari database
        $video->delete();

        return redirect()->route('video.index')->with('success', 'Video berhasil dihapus.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function bulkDelete(Request $request)
    {
        $ids = $request->delete_ids;

        if ($ids) {
            VideoLink::whereIn('id', $ids)->delete();
            return redirect()->route('video.index')->with('success', 'Data video berhasil dihapus.');
        }

        return redirect()->route('video.index')->with('error', 'Tidak ada video yang dipilih.');
    }
}
