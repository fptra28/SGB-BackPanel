<?php

namespace App\Http\Controllers;

use App\Models\Legalitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class LegalitasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Tampilkan daftar legalitas dengan pencarian & pagination.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $legalitasList = Legalitas::when($search, function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%");
        })
            ->latest()
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('legalitas.index', compact('legalitasList', 'search'));
    }

    /**
     * Form tambah.
     */
    public function create()
    {
        return view('legalitas.create');
    }

    /**
     * Simpan data baru.
     * Gambar disimpan ke public/uploads/legalitas.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        try {
            $imagePath = null;

            if ($request->hasFile('image')) {
                $imagePath = $this->saveImageToPublic($request->file('image'));
            }

            Legalitas::create([
                'title' => $validated['title'],
                'image' => $imagePath, // simpan relative path, contoh: uploads/legalitas/xxxx.jpg
            ]);

            return redirect()->route('legalitas.index')->with('success', 'Legalitas berhasil ditambahkan!');
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', 'Gagal menambahkan legalitas! ' . $e->getMessage());
        }
    }

    /**
     * Form edit.
     */
    public function edit($id)
    {
        $legalitas = Legalitas::findOrFail($id);
        return view('legalitas.edit', compact('legalitas'));
    }

    /**
     * Update data.
     * Jika upload gambar baru, hapus gambar lama dari public path.
     */
    public function update(Request $request, $id)
    {
        $legalitas = Legalitas::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        try {
            $data = [
                'title' => $validated['title'],
            ];

            if ($request->hasFile('image')) {
                // Hapus file lama jika ada
                if ($legalitas->image && File::exists(public_path($legalitas->image))) {
                    File::delete(public_path($legalitas->image));
                }
                $data['image'] = $this->saveImageToPublic($request->file('image'));
            }

            $legalitas->update($data);

            return redirect()->route('legalitas.index')->with('success', 'Legalitas berhasil diperbarui!');
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', 'Gagal memperbarui legalitas! ' . $e->getMessage());
        }
    }

    /**
     * Hapus data + file gambar (jika ada).
     */
    public function destroy($id)
    {
        $legalitas = Legalitas::find($id);

        if (!$legalitas) {
            return redirect()->route('legalitas.index')->with('error', 'Legalitas tidak ditemukan.');
        }

        try {
            if ($legalitas->image && File::exists(public_path($legalitas->image))) {
                File::delete(public_path($legalitas->image));
            }

            $legalitas->delete();

            return redirect()->route('legalitas.index')->with('success', 'Legalitas berhasil dihapus.');
        } catch (\Throwable $e) {
            return redirect()->route('legalitas.index')->with('error', 'Gagal menghapus legalitas! ' . $e->getMessage());
        }
    }

    /**
     * Simpan file gambar ke public/uploads/legalitas dan
     * kembalikan relative path yang disimpan ke DB.
     */
    protected function saveImageToPublic($file): string
    {
        $dest = public_path('uploads/legalitas');

        if (!File::isDirectory($dest)) {
            File::makeDirectory($dest, 0755, true);
        }

        $ext = strtolower($file->getClientOriginalExtension());
        $filename = time() . '_' . Str::random(12) . '.' . $ext;

        $file->move($dest, $filename);

        // Simpan rel. path, sehingga untuk tampil cukup asset($path)
        return 'uploads/legalitas/' . $filename;
    }
}
