<?php

use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});


Route::post('/EtkinlikTurEkle', [TestController::class, 'EtkinlikTurEkle'])->name('EtkinlikTurEkle');
Route::post('/EtkinlikTurEkle', [TestController::class, 'EtkinlikTurEkle'])->name('EtkinlikTurEkle');
