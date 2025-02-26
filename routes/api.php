<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Routes API Berita
Route::get('/berita', 'Api\BeritaController@index'); // Semua berita
Route::get('/berita/edit', 'Api\BeritaController@showById'); // Berdasarkan ID
Route::get('/berita/detail', 'Api\BeritaController@showByTitle'); // Berdasarkan Judul

// Routes API Video
Route::get('/video', 'Api\VideoController@index');
Route::get('/video/edit', 'Api\VideoController@showById');
