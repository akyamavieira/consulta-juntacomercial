<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstabelecimentosController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/estabelecimentos', [EstabelecimentosController::class, 'index']);
