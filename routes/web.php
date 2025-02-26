<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Authentification routes
Auth::routes();

// Home Page Routes
Route::get('/', 'HomeController@index')->name('home');

// Berita Page Routes
Route::get('/berita', 'BeritaController@index')->name('berita.berita');

Route::post('/berita', 'BeritaController@store')->name('berita.store');

Route::get('/berita/create', 'BeritaController@create')->name('berita.create');

Route::get('/berita/edit/{id}', 'BeritaController@edit')->name('berita.edit');

Route::put('/berita/edit/put/{id}', 'BeritaController@update')->name('berita.update');

Route::get('/berita/detail/{judul}', 'BeritaController@show')->name('berita.detail');

Route::delete('/berita/delete/{id}', 'BeritaController@destroy')->name('berita.destroy');

// Video Page Routes
Route::get('/video', 'VideoController@index')->name('video.index');

Route::post('/video', 'VideoController@store')->name('video.store');

Route::get('/video/create', 'VideoController@create')->name('video.create');

Route::get('/video/edit/{id}', 'VideoController@edit')->name('video.edit');

Route::put('/video/edit/put/{id}', 'VideoController@update')->name('video.update');

Route::delete('/video/delete/{id}', 'VideoController@destroy')->name('video.destroy');

// Profile Routes
Route::get('/profile', 'ProfileController@index')->name('profile');

Route::put('/profile', 'ProfileController@update')->name('profile.update');

Route::get('/about', function () {
    return view('about');
})->name('about');
