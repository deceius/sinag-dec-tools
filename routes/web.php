<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AlbionAPIController;
use App\Http\Controllers\BuildController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MarketController;
use App\Http\Controllers\RegearController;
use App\Http\Controllers\RegearReportController;
use Illuminate\Support\Facades\Route;
use Spatie\DiscordAlerts\Facades\DiscordAlert;

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

Route::get('/', [HomeController::class, 'index'])->name('welcome');
Route::get('/get-guild-data', [HomeController::class, 'getGuildData'])->name('welcome.guild-data');

Route::get('/get-builds', [BuildController::class, 'index'])->name('builds.fetch');


Route::get('/home', function () {
    return view('home');
})->middleware('auth', 'in_guild')->name('home');

Route::middleware('auth', 'in_guild')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/member/{id}', [ProfileController::class, 'bindCharacter'])->name('profile.update');
    Route::get('/aosearch', [AlbionAPIController::class, 'searchIGN'])->name('ao.search');
    Route::get('/loadchar', [AlbionAPIController::class, 'loadCharacter'])->name('ao.loadchar');
    Route::get('/deathlog', [AlbionAPIController::class, 'searchDeathLog'])->name('ao.death');
    Route::get('/fetchdeathlog', [AlbionAPIController::class, 'fetchDeathLog'])->name('ao.death');


    Route::patch('/regear/{regearInfo}/request', [RegearController::class, 'requestRegear'])->name('request.regear');
    Route::patch('/regear/{regearInfo}/update', [RegearController::class, 'processRegear'])->name('process.regear');
    Route::get('/regear/oc-break', function () { return view('regear.oc-create'); })->name('oc.request.regear');


    Route::get('/market', [MarketController::class, 'index'])->name('market');
    Route::get('/get-builds', [BuildController::class, 'index'])->name('builds.fetch');
    Route::get('/builds', function () { return view('builds.member-index'); })->name('builds');
});
Route::middleware('auth', 'in_guild', 'blck_market')->group(function () {
    Route::get('/black-market', [MarketController::class, 'bmIndex'])->name('black.market');
    Route::get('/black-market/details', [MarketController::class, 'bmDetails'])->name('black.market.details');
});
Route::middleware('auth', 'in_guild', 'officer')->group(function () {
    Route::get('/parseDeaths', [AlbionAPIController::class, 'fetchDeathLogByBattleId']);
    Route::get('/parseitems', [AlbionAPIController::class, 'parseItems'])->name('ao.parseitems');
    Route::get('/getitems', [AlbionAPIController::class, 'getItemList'])->name('ao.getitems');


    Route::get('reports/regear', [RegearReportController::class, 'index'])->name('reports.regear.index');
    Route::get('reports/regear/fetch/losses', [RegearReportController::class, 'fetchGuildLosses'])->name('reports.regear.fetch.losses');
    Route::get('reports/regear/fetch/pendingitems', [RegearReportController::class, 'fetchPendingRegears'])->name('reports.regear.fetch.pendingitems');
    Route::get('reports/regear/fetch/deathstats', [RegearReportController::class, 'fetchDeathStats'])->name('reports.regear.fetch.pendingitems');

    Route::get('/officer/regear/index', [RegearController::class, 'index'])->name('officer.regear.index');
    Route::get('/officer/regear/fetch', [RegearController::class, 'fetchAllRegears'])->name('regear.fetch');

    Route::get('/officer/build/index', [BuildController::class, 'index'])->name('officer.build.index');

    Route::get('/officer/build/create', [BuildController::class, 'create'])->name('build.create');
    Route::get('/officer/build/{buildInfo}/edit', [BuildController::class, 'edit'])->name('build.edit');
    Route::post('/officer/build/{buildInfo}/delete', [BuildController::class, 'delete'])->name('build.delete');
    Route::post('/officer/build/save', [BuildController::class, 'store'])->name('build.save');
});
