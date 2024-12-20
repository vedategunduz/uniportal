<?php

use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});


Route::post('/', [TestController::class, 'EtkinlikTurEkle'])->name('ekle');
