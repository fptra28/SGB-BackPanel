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

// Route::post('/login', function (Request $request) {
//     $credentials = $request->validate([
//         'email' => 'required|email',
//         'password' => 'required',
//     ]);

//     if (!Auth::attempt($credentials)) {
//         return response()->json(['message' => 'Unauthorized'], 401);
//     }

//     $user = Auth::user();
//     $token = $user->createToken('access-Api')->plainTextToken;

//     return response()->json([
//         'message' => 'Login successful',
//         'token' => $token,
//         'user' => $user
//     ]);
// });

Route::get('/berita', 'Api\BeritaController@index'); // Semua berita
Route::get('/berita/edit', 'Api\BeritaController@showById'); // Berdasarkan ID
Route::get('/berita/detail', 'Api\BeritaController@showByTitle'); // Berdasarkan Judul

Route::post('/berita', 'Api\BeritaController@store'); // Perlu autentikasi  
Route::put('/berita/edit/{id}', 'Api\BeritaController@update'); // Perlu autentikasi
Route::delete('/berita/delete/{id}', 'Api\BeritaController@destroy'); // Perlu autentikasi
