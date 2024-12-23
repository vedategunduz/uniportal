<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\KullaniciController;
use App\Http\Controllers\DashboardController;

use App\Http\Middleware\GirisYapildiMiddleware;

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(GirisYapildiMiddleware::class);

Route::get('/profile/{id?}', [KullaniciController::class, 'show']);

Route::prefix('giris')->group(function() {
    Route::get('/', [KullaniciController::class, 'giris']);
    Route::post('/', [KullaniciController::class, 'giris_yap'])->name('giris_yap');
});

Route::get('/cikis', [KullaniciController::class, 'cikis'])->name('cikis_yap');
