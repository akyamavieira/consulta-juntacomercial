<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstabelecimentosController;
use App\Http\Middleware\VerifyKeycloakAuth;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\AbstractProvider;

Route::get('/', [EstabelecimentosController::class, 'index'])
    ->name('index')->middleware([VerifyKeycloakAuth::class]);

Route::get('/wait', function () {
    return view('errors.wait');
})->name("wait")->middleware([VerifyKeycloakAuth::class]);

Route::get('login/keycloak', 'LoginController@redirectToKeycloak')->name('login.keycloak');
Route::get('login/keycloak/callback', 'LoginController@handleKeycloakCallback');