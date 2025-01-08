<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class KeycloakCallBack extends Controller
{
    public function keycloakCallBack()
    {
        /** @var \Laravel\Socialite\Two\AbstractProvider  */
        $driver = Socialite::driver('keycloak');

        // Ignora a verificação SSL
        $guzzleClient = new \GuzzleHttp\Client(array('curl' => array(CURLOPT_SSL_VERIFYPEER => false,),));
        $driver->setHttpClient($guzzleClient);

        $user = $driver->stateless()->user();

        return redirect()->to('/');
    }
}
