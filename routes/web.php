<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AnasayfaController;
use App\Http\Controllers\KullaniciController;
use App\Http\Controllers\EtkinlikController;
use App\Http\Controllers\KamularController;

Route::prefix('/')->group(function () {
    Route::get('/', [AnasayfaController::class, 'index'])->name('index');
});

Route::prefix('kamular')->name('kamular.')->group(function () {
    Route::get('/', [KamularController::class, 'index'])->name('index');
});

Route::prefix('etkinlik')->name('etkinlik.')->group(function () {

    Route::prefix('ekle')->name('ekle.')->group(function () {
        Route::get('/', [EtkinlikController::class, 'create'])->name('create');
        Route::post('/', [EtkinlikController::class, 'store'])->name('store');
    });
});

Route::prefix('kullanici')->name('kullanici.')->group(function () {
    Route::get('/', [KullaniciController::class, 'index'])->name('index');

    Route::prefix('giris')->name('giris.')->group(function () {
        Route::get('/', [KullaniciController::class, 'girisForm'])->name('form');
        Route::post('/', [KullaniciController::class, 'girisYap'])->name('yap');
    });

    Route::get('/cikis', [KullaniciController::class, 'cikis'])->name('cikis');
});
