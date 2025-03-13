<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
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
        $search = $request->input('search');

        $banners = Banner::when($search, function ($query, $search) {
            return $query->where('title', 'like', "%{$search}%")
                ->orwhere('description', 'like', "%{$search}%");
        })->get();

        return view('hero.index', compact('banners', 'search'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('hero.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:50|unique:banners,title',
            'description' => 'required|string|max:150',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            // Upload gambar
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('images/banners'), $imageName);

            // Simpan ke database
            Banner::create([
                'title' => $request->title,
                'description' => $request->description,
                'image' => $imageName,
            ]);

            return redirect()->route('hero.index')->with('success', 'Hero berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->route('hero.index')->with('error', 'Gagal menambahkan hero! ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $banner = Banner::findOrFail($id);

        return view('hero.show', compact('banner'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $banner = Banner::findOrFail($id);

        return view('hero.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        // Validasi input
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update data
        $banner->title = $request->title;
        $banner->description = $request->description;

        // Jika ada file baru diunggah
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($banner->image && file_exists(public_path('images/banners/' . $banner->image))) {
                unlink(public_path('images/banners/' . $banner->image));
            }

            // Simpan gambar baru
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/banners'), $imageName);
            $banner->image = $imageName;
        }

        $banner->save();

        return redirect()->route('hero.index')->with('success', 'Banner updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $banner = Banner::findOrFail($id);

        // Hapus gambar jika ada
        if ($banner->image && file_exists(public_path('images/banners/' . $banner->image))) {
            unlink(public_path('images/banners/' . $banner->image));
        }

        $banner->delete();

        return redirect()->route('hero.index')->with('success', 'Hero deleted successfully.');
    }
}
