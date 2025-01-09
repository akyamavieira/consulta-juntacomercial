<?php

use App\Http\Controllers\auth\KeycloakCallBack;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstabelecimentosController;
use App\Http\Middleware\VerifyKeycloakAuth;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\AbstractProvider;

Route::get('/', [EstabelecimentosController::class, 'index'])->name('index')->middleware([VerifyKeycloakAuth::class]);
Route::get('/wait', function () {
    return view('errors.wait');
})->name("wait")->middleware([VerifyKeycloakAuth::class]);

Route::get('/callback/keycloak', [KeycloakCallBack::class, 'keycloakCallBack']);

Route::get('/login', function (){
    return Socialite::driver('keycloak')->redirect();
});