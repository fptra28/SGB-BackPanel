<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/berita', 'Api\BeritaController@index'); // Semua berita

Route::get('/berita/detail', 'Api\BeritaController@showByTitle'); // Detail berdasarkan judul (jdID)

Route::post('/berita', 'Api\BeritaController@store');
