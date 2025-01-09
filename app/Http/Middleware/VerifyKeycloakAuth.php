<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
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
            /** @var \Laravel\Socialite\Two\AbstractProvider */
            $driver = Socialite::driver('keycloak');

            // Verifica se o usuário está na sessão
            if (!Session::has('user')) {
                return $driver->stateless()->redirect();
            }

            $user = Session::get('user');

            // Verifica se o usuário tem ID válido
            if (!$user || !$user->getId()) {
                return $driver->stateless()->redirect();
            }

            // Adiciona o usuário na requisição para uso futuro
            $request->merge(['keycloak_user' => $user]);

            return $next($request);
        } catch (InvalidStateException $e) {
            /** @var \Laravel\Socialite\Two\AbstractProvider */
            $driver = Socialite::driver('keycloak');

            Log::error('Erro ao verificar a sessão do Keycloak: InvalidStateException', ['exception' => $e]);
            return $driver->stateless()->redirect();
        } catch (\Exception $e) {
            /** @var \Laravel\Socialite\Two\AbstractProvider */
            $driver = Socialite::driver('keycloak');

            Log::error('Erro inesperado ao verificar a sessão do Keycloak', ['exception' => $e]);
            return $driver->stateless()->redirect();
        }
    }
}
