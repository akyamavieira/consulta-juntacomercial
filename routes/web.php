<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstabelecimentosController;
use Laravel\Socialite\Facades\Socialite;

Route::get('/', [EstabelecimentosController::class, 'index'])->name('index');
Route::get('/wait', function () {
    return view('errors.wait');
})->name("wait");

Route::get('/callback/keycloak', function () {
    $user = Socialite::driver('keycloak')->user();

    // Aqui você pode salvar o usuário ou criar a lógica de login
    dd($user);

    //return redirect()->to('/home');
});

Route::get('/login', function (){
    session()->forget('state'); 
    return Socialite::driver('keycloak')->redirect();
});