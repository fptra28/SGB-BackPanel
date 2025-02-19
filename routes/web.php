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
Route::get('/berita', 'BeritaController@index')->name('berita');

// Profile Routes
Route::get('/profile', 'ProfileController@index', function () {
    return view('profile', ['title' => 'Profile']);
})->name('profile');

Route::put('/profile', 'ProfileController@update')->name('profile.update');

Route::get('/about', function () {
    return view('about');
})->name('about');
