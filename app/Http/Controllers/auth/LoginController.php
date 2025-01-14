<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function redirectToKeycloak()
    {
        // Keycloak below v3.2 requires no scopes to be set. 
        // Later versions require the openid scope for all requests.
        // e.g return Socialite::driver('keycloak')->scopes(['openid'])->redirect();
        return Socialite::driver('keycloak')->redirect();
        
    }

    public function handleKeycloakCallback()
    {
        $user = Socialite::driver('keycloak')->user();

        // this line will be needed if you have an exist Eloquent database User
        // then you can user user data gotten from keycloak to query such table
        // and proceed
        $existingUser = User::where('email', $user->email)->first();

        // ... your desire implementation comes here

        return redirect()->intended('/');
    }
}