<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EstabelecimentosController;
use App\Http\Middleware\VerifyKeycloakAuth;
use App\Http\Controllers\AtualizarBairrosController;

Route::get('/atualizar-bairros', [AtualizarBairrosController::class, 'atualizar']);

// Rota principal protegida por middleware
Route::get('/', [EstabelecimentosController::class, 'index'])
    ->name('index')->withoutMiddleware([VerifyKeycloakAuth::class]);

// Rota de espera (também protegida por middleware)
Route::get('/wait', function () {
    return view('errors.wait');
})->name("wait");

// Rotas de autenticação com Keycloak
Route::get('/login', [LoginController::class, 'redirectToKeycloak'])->name('login')->withoutMiddleware([VerifyKeycloakAuth::class]);
Route::get('/callback', [LoginController::class, 'handleKeycloakCallback'])->name('callback')->withoutMiddleware([VerifyKeycloakAuth::class]);
Route::post('/backchannel-logout', [LoginController::class, 'backchannelLogout'])->name('backchannel.logout');
