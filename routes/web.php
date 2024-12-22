<?php

use App\Http\Controllers\KullaniciController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/giris', [KullaniciController::class, 'create']);
Route::post('/giris', [KullaniciController::class, 'login'])->name('giris');

Route::get('/cikis', [KullaniciController::class, 'logout']);

Route::post('/EtkinlikTurEkle', [TestController::class, 'EtkinlikTurEkle'])->name('EtkinlikTurEkle');
Route::post('/EtkinlikTurEkle', [TestController::class, 'EtkinlikTurEkle'])->name('EtkinlikTurEkle');
