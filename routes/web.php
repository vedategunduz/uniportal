<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AnasayfaController;
use App\Http\Controllers\EditorController;
use App\Http\Controllers\KullaniciController;
use App\Http\Controllers\EtkinlikController;
use App\Http\Controllers\KamularController;

Route::prefix('/')->name('main.')->group(function () {
    Route::get('/', [AnasayfaController::class, 'index'])->name('index');
});

Route::prefix('isletmeler')->name('isletmeler.')->group(function () {
    Route::get('/', [KamularController::class, 'index'])->name('index');
});

Route::prefix('etkinlikler')->name('etkinlik.')->group(function () {

    Route::get('/', [EtkinlikController::class, 'index'])->name('index');

    Route::prefix('ekle')->name('ekle.')->group(function () {
        Route::get('/', [EtkinlikController::class, 'create'])->name('create');
        Route::post('/', [EtkinlikController::class, 'store'])->name('store');
    });
});

Route::prefix('kullanici')->name('kullanici.')->group(function () {
    Route::get('/', [KullaniciController::class, 'index'])->name('index');

    Route::get('/menu', [KullaniciController::class, 'menu'])->name('menu');

    Route::prefix('giris')->name('giris.')->group(function () {
        Route::get('/', [KullaniciController::class, 'girisForm'])->name('form');
        Route::post('/', [KullaniciController::class, 'girisYap'])->name('yap');
    });

    Route::get('/cikis', [KullaniciController::class, 'cikis'])->name('cikis');
});

Route::prefix('editor')->name('editor.')->group(function () {
    Route::post('store', [EditorController::class, 'store'])->name('store');

    Route::get('summernote', [EditorController::class, 'index'])->name('index');

    Route::prefix('file')->name('file.')->group(function () {
        Route::post('upload', [EditorController::class, 'fileUpload'])->name('yukle');
    });

    Route::prefix('image')->name('image.')->group(function () {
        Route::post('upload', [EditorController::class, 'imageUpload']);
    });
});
