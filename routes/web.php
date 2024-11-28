<?php

use App\Http\Controllers\ShortUrlController;
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

Route::get('/', [ShortUrlController::class, 'home'])->name('home');
Route::get('/all-url-list', [ShortUrlController::class, 'allUrlList'])->name('all_url_list');
Route::post('/shorten', [ShortUrlController::class, 'shorten'])->name('shorten');
Route::get('/{shortCode}', [ShortUrlController::class, 'redirect']);




