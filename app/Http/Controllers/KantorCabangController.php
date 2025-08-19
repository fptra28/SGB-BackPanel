<?php

namespace App\Http\Controllers;

use App\Models\KantorCabang;
use Illuminate\Http\Request;

class KantorCabangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // opsional jika area admin
    }

    /**
     * Tampilkan daftar kantor cabang (pagination).
     */
    public function index()
    {
        $kantorCabangs = KantorCabang::latest()->paginate(10);
        return view('kantor-cabang.index', compact('kantorCabangs'));
    }

    /**
     * Form create.
     */
    public function create()
    {
        return view('kantor-cabang.create');
    }

    /**
     * Simpan data baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kantor_cabang'    => 'required|string|max:150',
            'alamat_kantor_cabang'  => 'required|string',      // text pada migration → tidak dibatasi length
            'fax_kantor_cabang'     => 'required|string|max:50',
            'telepon_kantor_cabang' => 'required|string|max:50',
            'maps_kantor_cabang'    => 'required|string',      // text pada migration
        ]);

        try {
            KantorCabang::create($validated);
            return redirect()->route('kantor-cabang.index')->with('success', 'Kantor cabang berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan kantor cabang: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Form edit.
     */
    public function edit($id)
    {
        $kantorCabang = KantorCabang::findOrFail($id);
        return view('kantor-cabang.edit', compact('kantorCabang'));
    }

    /**
     * Update data.
     */
    public function update(Request $request, $id)
    {
        $kantorCabang = KantorCabang::findOrFail($id);

        $validated = $request->validate([
            'nama_kantor_cabang'    => 'required|string|max:150',
            'alamat_kantor_cabang'  => 'required|string',
            'fax_kantor_cabang'     => 'required|string|max:50',
            'telepon_kantor_cabang' => 'required|string|max:50',
            'maps_kantor_cabang'    => 'required|string',
        ]);

        try {
            $kantorCabang->update($validated);
            return redirect()->route('kantor-cabang.index')->with('success', 'Kantor cabang berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui kantor cabang: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Hapus satu data.
     */
    public function destroy($id)
    {
        $kantorCabang = KantorCabang::find($id);

        if (!$kantorCabang) {
            return redirect()->route('kantor-cabang.index')->with('error', 'Kantor cabang tidak ditemukan.');
        }

        try {
            $kantorCabang->delete();
            return redirect()->route('kantor-cabang.index')->with('success', 'Kantor cabang berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus kantor cabang: ' . $e->getMessage());
        }
    }
}
