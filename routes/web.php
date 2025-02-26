<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EstabelecimentosController;
use App\Http\Middleware\VerifyKeycloakAuth;

$middleware = env('APP_ENV') === 'produção' ? [VerifyKeycloakAuth::class] : [];
// Rota principal protegida por middleware
Route::get('/', [EstabelecimentosController::class, 'index'])
    ->name('index')->middleware($middleware);

// Rotas de autenticação com Keycloak
Route::get('/login', [LoginController::class, 'redirectToKeycloak'])->name('login')->withoutMiddleware([VerifyKeycloakAuth::class]);
Route::get('/callback', [LoginController::class, 'handleKeycloakCallback'])->name('callback')->withoutMiddleware([VerifyKeycloakAuth::class]);
Route::post('/backchannel-logout', [LoginController::class, 'backchannelLogout'])->name('backchannel.logout');
