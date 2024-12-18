<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstabelecimentosController;

 


Route::get('/', [EstabelecimentosController::class, 'index'])->name('index');
Route::get('/wait', function () {
    return view('errors.wait');
})->name("wait");