<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\KullaniciController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EtkinlikController;
use App\Http\Controllers\KamularController;
use App\Http\Middleware\GirisYapildiMiddleware;

Route::get('/', function () {
    return view('home');
});

Route::get('/kamular', [KamularController::class, 'index']);

Route::get('/etkinlik/ekle', [EtkinlikController::class, 'create'])->name('etkinlik_ekleme_sayfasi');
Route::post('/etkinlik/ekle', [EtkinlikController::class, 'store'])->name('etkinlik_ekle');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(GirisYapildiMiddleware::class);

Route::prefix('giris')->group(function() {
    Route::get('/', [KullaniciController::class, 'giris']);
    Route::post('/', [KullaniciController::class, 'giris_yap'])->name('giris_yap');
});

Route::get('/cikis', [KullaniciController::class, 'cikis'])->name('cikis_yap');
