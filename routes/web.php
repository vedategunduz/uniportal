<?php

use App\Http\Controllers\MenuController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/firmalar', [TestController::class, 'firmalar'])->name('firmalar');
Route::get('/kamular', [TestController::class, 'kamular'])->name('kamular');

Route::get('menu', [MenuController::class, 'index']);
