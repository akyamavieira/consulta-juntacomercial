<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use Symfony\Component\HttpFoundation\Response;

class VerifyKeycloakAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            if (!Session::has('user')) {
                return redirect()->to('/login');
            }

            // Tenta recuperar o usuário do Keycloak a partir da sessão
            /** @var \Laravel\Socialite\Two\AbstractProvider  */
            $driver = Socialite::driver('keycloak');
            $user = Session::get('user');

            if (!$user || !$user->getId()) {
                return redirect()->to('/login');
            }

            $request->merge(['keycloak_user' => $user]);

            // Continua o fluxo da aplicação
            return $next($request);
        } catch (InvalidStateException $e) {
            // Caso ocorra um erro no OAuth (como um estado inválido)
            Log::error('Erro ao verificar a sessão do Keycloak: InvalidStateException', ['exception' => $e]);
            return redirect()->to('/login');
        } catch (\Exception $e) {
            // Captura qualquer outro erro inesperado
            Log::error('Erro inesperado ao verificar a sessão do Keycloak', ['exception' => $e]);
            return redirect()->to('/login');
        }
    }
}
