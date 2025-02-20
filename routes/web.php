<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Authentification routes
Auth::routes();

// Home Page Routes
Route::get('/', 'HomeController@index')->name('home');

// Berita Page Routes
Route::get('/berita', 'BeritaController@index')->name('berita.berita');

Route::post('/berita', 'BeritaController@store')->name('berita.store');

Route::get('/berita/create', 'BeritaController@create')->name('berita.create');

Route::get('/berita/edit/{id}', 'BeritaController@edit')->name('berita.edit');

Route::put('/berita/edit/{id}', 'BeritaController@update')->name('berita.update');

Route::get('/berita/detail/{judul}', 'BeritaController@show')->name('berita.detail');

// Profile Routes
Route::get('/profile', 'ProfileController@index')->name('profile');

Route::put('/profile', 'ProfileController@update')->name('profile.update');

Route::get('/about', function () {
    return view('about');
})->name('about');
