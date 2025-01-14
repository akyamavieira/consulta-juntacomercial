<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Redireciona para o Keycloak.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToKeycloak()
    {
        // Keycloak abaixo da versão 3.2 não requer scopes. Versões posteriores requerem o scope 'openid'.
        return Socialite::driver('keycloak')->redirect();
    }

    /**
     * Callback do Keycloak após autenticação.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleKeycloakCallback()
    {
        // Obtém o usuário autenticado no Keycloak
        /** @var \Laravel\Socialite\Two\AbstractProvider  */
        $driver = Socialite::driver('keycloak');
        // Ignora a verificação SSL
        $guzzleClient = new \GuzzleHttp\Client(array('curl' => array(CURLOPT_SSL_VERIFYPEER => false,),));
        $driver->setHttpClient($guzzleClient);
        $user = $driver->stateless()->user();
        // Verifica se o usuário já existe no banco de dados
        $existingUser = User::where('email', $user->email)->first();

        if ($existingUser) {
            // Autentica o usuário existente
            Auth::login($existingUser);
        } else {
            // Cria um novo usuário, se necessário
            $newUser = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'keycloak_id' => $user->id, // Certifique-se de ter esta coluna na tabela de usuários
            ]);

            Auth::login($newUser);
        }

        // Redireciona para a rota principal após o login
        return redirect()->intended('/');
    }
}
