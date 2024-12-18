<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstabelecimentosController;

 


Route::get('/', [EstabelecimentosController::class, 'index'])->name('index');
Route::get('/test-wait', function () {
    return view('errors.wait');
})->name("test");