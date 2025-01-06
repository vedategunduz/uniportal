<?php

use Illuminate\Support\Facades\Route;

use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\NotAuthMiddleware;

use App\Http\Controllers\AnasayfaController;
use App\Http\Controllers\EditorController;
use App\Http\Controllers\KullaniciController;
use App\Http\Controllers\EtkinlikController;
use App\Http\Controllers\IsletmelerController;

Route::prefix('/')->name('main.')->group(function () {
    Route::get('/', [AnasayfaController::class, 'index'])->name('index');
});

Route::prefix('isletmeler')->name('isletmeler.')->group(function () {
    Route::get('/', [IsletmelerController::class, 'index'])->name('index');
});

Route::prefix('etkinlikler')->name('etkinlikler.')->group(function () {
    Route::get('/', [EtkinlikController::class, 'index'])->name('index');

    Route::prefix('ekle')->name('ekle.')->group(function () {
        Route::post('/', [EtkinlikController::class, 'store'])->name('store');
    });
});



Route::prefix('kullanici')->name('kullanici.')->group(function () {

    Route::middleware(AuthMiddleware::class)->group(function () {
        Route::get('/', [KullaniciController::class, 'index'])->name('index');

        Route::prefix('etkinlikler')->name('etkinlikler.')->group(function () {
            Route::get('/', [EtkinlikController::class, 'index'])->name('index');

            Route::post('/', [EtkinlikController::class, 'store']);
            Route::post('/duzenle/{id}', [EtkinlikController::class, 'update']);
            // Etkinlik modalları
            Route::prefix('modal')->group(function () {
                Route::get('/ekle', [KullaniciController::class, 'modalEkle']);
                Route::get('/duzenle/{id}', [KullaniciController::class, 'modalDuzenle']);
            });
        });

        Route::prefix('isletmeler')->name('isletmeler.')->group(function () {
            Route::get('/kamular', [KullaniciController::class, 'kamular'])->name('kamular');
            Route::get('/firmalar', [KullaniciController::class, 'firmalar'])->name('firmalar');
            Route::get('/sendikalar', [KullaniciController::class, 'sendikalar'])->name('sendikalar');
        });
    });

    // Giriş rota grubu
    Route::prefix('giris')->name('giris.')->group(function () {
        // Giriş formu
        Route::get('/', [KullaniciController::class, 'girisForm'])->name('form');
        // Giriş işlemi
        Route::post('/', [KullaniciController::class, 'girisYap'])->name('yap');
    })->middleware(NotAuthMiddleware::class);

    // Çıkış rotası
    Route::get('/cikis', [KullaniciController::class, 'cikis'])
        ->name('cikis')
        ->middleware(AuthMiddleware::class);
});

Route::prefix('editor')->name('editor.')->group(function () {
    Route::prefix('file')->name('file.')->group(function () {
        Route::post('upload', [EditorController::class, 'fileUpload'])->name('yukle');
    });

    Route::prefix('image')->name('image.')->group(function () {
        Route::post('upload', [EditorController::class, 'imageUpload'])->name('yukle');
    });
});
