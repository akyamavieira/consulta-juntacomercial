<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EstabelecimentosController;
use App\Http\Middleware\VerifyKeycloakAuth;

// Rota principal protegida por middleware
Route::get('/', [EstabelecimentosController::class, 'index'])
    ->name('index')
    ->middleware([VerifyKeycloakAuth::class]);

// Rota de espera (também protegida por middleware)
Route::get('/wait', function () {
    return view('errors.wait');
})->name("wait")->middleware([VerifyKeycloakAuth::class]);

// Rotas de autenticação com Keycloak
Route::get('/login', [LoginController::class, 'redirectToKeycloak'])->name('login.keycloak');
Route::get('/callback', [LoginController::class, 'handleKeycloakCallback']);
