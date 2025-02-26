<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VideoLink;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(VideoLink::All(), 200);
    }

    // Ambil berita berdasarkan ID
    public function showById(Request $request)
    {
        $id = $request->query('id');

        // Pastikan ID valid
        if (is_null($id) || !filter_var($id, FILTER_VALIDATE_INT)) {
            return response()->json([
                'success' => false,
                'message' => 'Parameter id harus berupa angka'
            ], 400);
        }

        // Cari data berdasarkan ID
        $video = VideoLink::find($id);

        // Jika tidak ditemukan, kirim respon 404
        if (!$video) {
            return response()->json([
                'success' => false,
                'message' => 'Video tidak ditemukan'
            ], 404);
        }

        // Kirim response sukses
        return response()->json([
            'success' => true,
            'data' => $video
        ]);
    }
}
