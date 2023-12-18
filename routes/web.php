<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AlbionAPIController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
})->middleware(['auth'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/member/{id}', [ProfileController::class, 'bindCharacter'])->name('profile.update');
    Route::get('/aosearch', [AlbionAPIController::class, 'searchIGN'])->name('ao.search');
    Route::get('/loadchar', [AlbionAPIController::class, 'loadCharacter'])->name('ao.loadchar');
    Route::get('/deathlog', [AlbionAPIController::class, 'searchDeathLog'])->name('ao.death');
});
