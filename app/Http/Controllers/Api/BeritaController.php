<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Berita;

class BeritaController extends Controller
{
    // app/Http/Controllers/Api/BeritaController.php
    public function index()
    {
        // Ambil data berita dan penulisnya
        $beritas = Berita::with('author')->latest()->get();

        // Kembalikan data dalam bentuk JSON
        return response()->json($beritas);
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        $request->validate([
            'Judul' => 'required|max:100',
            'Isi' => 'required',
            'image1' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'image2' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'image3' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'image4' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'image5' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        Berita::create([
            'image1' => $request->file('image1')->store('uploads', 'public'),
            'image2' => $request->file('image2')->store('uploads', 'public'),
            'image3' => $request->file('image3')->store('uploads', 'public'),
            'image4' => $request->file('image4')->store('uploads', 'public'),
            'image5' => $request->file('image5')->store('uploads', 'public'),
            'Judul' => $request->Judul,
            'Isi' => $request->Isi,
            'author_id' => Auth::id(), // Ganti auth()->id() dengan Auth::id()
        ]);


        return redirect()->route('berita.index')->with('success', 'Berita berhasil ditambahkan.');
    }
}
