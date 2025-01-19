<?php

use Illuminate\Support\Facades\Route;

use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\NotAuthMiddleware;

use App\Http\Controllers\AnasayfaController;
use App\Http\Controllers\BirimlerController;
use App\Http\Controllers\EditorController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ResimController;
use App\Http\Controllers\Yonetim\KullaniciController;
use App\Http\Controllers\YonetimController;

Route::prefix('/')->name('main.')->group(function () {
    Route::get('/', [AnasayfaController::class, 'index'])->name('index');
});

Route::prefix('api')->name('api.')->group(function () {

    Route::prefix('modal')->name('modal.')->group(function () {
        Route::prefix('etkinlik')->group(function () {
            Route::post('/{id}', [EventController::class, 'modalGetir']);
            Route::post('sil/{id}', [EventController::class, 'silmeModalGetir']);
        });
        Route::prefix('kullanicilar')->group(function () {
            // Kullanici id'si ve işletme id'si form ile gönderilecek
            Route::post('/', [KullaniciController::class, 'silmeModalGetir']);
            Route::post('birimden-cikart', [KullaniciController::class, 'birimdenCikarModalGetir']);
            Route::post('detay/{id}', [KullaniciController::class, 'detayModalGetir']);
        });
    });

    Route::prefix('yonetim')->name('yonetim.')->group(function () {
        Route::prefix('kullanicilar')->group(function () {
            Route::get('show/{isletmeler_id}', [KullaniciController::class, 'show']);
            Route::post('sil', [KullaniciController::class, 'sil']);
            Route::post('birimden-cikart', [KullaniciController::class, 'birimdenCikart']);
            Route::post('unvan-degistir', [KullaniciController::class, 'unvanDegistir']);
            Route::post('duzenle', [KullaniciController::class, 'update']);
        });
    });

    Route::prefix('etkinlik')->name('etkinlik.')->group(function () {
        Route::post('ekle', [EventController::class, 'store']);
        Route::post('guncelle', [EventController::class, 'update']);
        Route::post('sil', [EventController::class, 'etkinlikSil']);
        Route::post('resmi-kaldir/{id}', [ResimController::class, 'destroy']);
    });
});

Route::post('/birimler/getir', [BirimlerController::class, 'getTable']);
Route::post('/birimler/sil/', [BirimlerController::class, 'birimSil']);

Route::prefix('yonetim')->name('yonetim.')->group(function () {

    Route::middleware(AuthMiddleware::class)->group(function () {
        Route::get('/', [YonetimController::class, 'index'])->name('index');

        Route::prefix('birimler')->name('birimler.')->group(function () {
            Route::get('/', [BirimlerController::class, 'index'])->name('index');

            Route::post('/guncelle', [BirimlerController::class, 'guncelle']);
            Route::post('/ekle', [BirimlerController::class, 'ekle']);
            Route::post('/personeller', [BirimlerController::class, 'personeller']);
            Route::post('/birimeYerlesmemisPersonelSayisi', [BirimlerController::class, 'birimeYerlesmemisPersonelSayisi']);
            Route::post('/personelBirimDegistir', [BirimlerController::class, 'change']);
            Route::post('/personelBirimAta', [BirimlerController::class, 'personelBirimAta']);
            Route::post('/personelEklemeListesi/{birimler_id}/{search}', [BirimlerController::class, 'personelEklemeListesi']);

            Route::post('/modal/{id}', [BirimlerController::class, 'getModal']);
            Route::post('/modal/birimKullanicilari/{id}', [BirimlerController::class, 'getModalIsletmeKullanicilari']);

            Route::post('/kullanici/{id}', [BirimlerController::class, 'destroy']);
            // Route::post('/patates', [BirimlerController::class, 'change']);
        });

        Route::prefix('etkinlikler')->name('etkinlikler.')->group(function () {
            Route::get('/', [EventController::class, 'index'])->name('index');
            Route::get('/show/{isletmeler_id}', [EventController::class, 'getDataTableDatas'])->name('show');
        });

        Route::prefix('kullanicilar')->name('kullanicilar.')->group(function () {
            Route::get('/', [KullaniciController::class, 'index']);
        });
    });
});

Route::prefix('editor')->name('editor.')->group(function () {
    Route::prefix('file')->name('file.')->group(function () {
        Route::post('upload', [EditorController::class, 'fileUpload'])->name('yukle');
    });

    Route::prefix('image')->name('image.')->group(function () {
        Route::post('upload', [EditorController::class, 'imageUpload'])->name('yukle');
    });
});

// Giriş rota grubu
Route::prefix('giris')->name('giris.')->group(function () {
    Route::get('/', [KullaniciController::class, 'girisForm'])->name('form');
    Route::post('/', [KullaniciController::class, 'girisYap'])->name('yap');
})->middleware(NotAuthMiddleware::class);

// Çıkış rotası
Route::get('/cikis', [KullaniciController::class, 'cikis'])->name('cikis')->middleware(AuthMiddleware::class);
