<?php

namespace App\Http\Controllers;

use App\Models\VideoLink;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $videos = VideoLink::when($search, function ($query, $search) {
            return $query->where('title', 'LIKE', "%{$search}%");
        })
            ->latest()
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('video.index', compact('videos'));
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
        $validated = $request->validate([
            'title'      => 'required|string|max:100|unique:videos,title',
            'embed_code' => 'required|string',
            'image'      => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        try {
            $imagePath = null;

            if ($request->hasFile('image')) {
                $file     = $request->file('image');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/videos'), $filename);

                // Simpan path relatif (agar mudah dipanggil di view)
                $imagePath = 'uploads/videos/' . $filename;
            }

            VideoLink::create([
                'title'      => $validated['title'],
                'embed_code' => $validated['embed_code'],
                'image'      => $imagePath,
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
        $video = VideoLink::findOrFail($id);
        return view('video.edit', compact('video'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $video = VideoLink::findOrFail($id);

        $validated = $request->validate([
            'title'      => 'required|string|max:100|unique:videos,title,' . $video->id,
            'embed_code' => 'required|string',
            'image'      => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        try {
            $data = [
                'title'      => $validated['title'],
                'embed_code' => $validated['embed_code'],
            ];

            if ($request->hasFile('image')) {
                // Hapus file lama jika ada
                if ($video->image && file_exists(public_path($video->image))) {
                    unlink(public_path($video->image));
                }

                $file     = $request->file('image');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/videos'), $filename);

                $data['image'] = 'uploads/videos/' . $filename;
            }

            $video->update($data);

            return redirect()->route('video.index')->with('success', 'Video berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui video! ' . $e->getMessage());
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

        if ($video->image && file_exists(public_path($video->image))) {
            unlink(public_path($video->image));
        }

        $video->delete();

        return redirect()->route('video.index')->with('success', 'Video berhasil dihapus.');
    }

    /**
     * Bulk delete selected resources.
     */
    public function bulkDelete(Request $request)
    {
        $ids = $request->delete_ids;

        if ($ids && is_array($ids)) {
            $videos = VideoLink::whereIn('id', $ids)->get();

            foreach ($videos as $video) {
                if ($video->image && file_exists(public_path($video->image))) {
                    unlink(public_path($video->image));
                }
            }

            VideoLink::whereIn('id', $ids)->delete();

            return redirect()->route('video.index')->with('success', 'Data video berhasil dihapus.');
        }

        return redirect()->route('video.index')->with('error', 'Tidak ada video yang dipilih.');
    }
}
