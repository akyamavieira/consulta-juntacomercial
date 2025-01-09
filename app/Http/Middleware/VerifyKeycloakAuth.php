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
        
            /** @var \Laravel\Socialite\Two\AbstractProvider */
            $driver = Socialite::driver('keycloak');

            // Verifica se o usuário está autenticado na sessão
            if (!Session::has('user') || !Session::get('user')['id']) {
                // Previne loops de redirecionamento
                if ($request->route()->getName() === 'keycloak.callback') {
                    Log::error('Redirecionamento em loop detectado.');
                    abort(500, 'Erro de redirecionamento em loop.');
                }

                return $driver->stateless()->redirect();
            }
            return $next($request);
    }
}

