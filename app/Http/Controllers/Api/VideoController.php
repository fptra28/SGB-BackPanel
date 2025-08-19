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
        $videos = VideoLink::all();

        return response()->json([
            'status' => 200,
            'message' => 'Data Video berhasil diambil',
            'data' => $videos,
        ]);     
    }
}
